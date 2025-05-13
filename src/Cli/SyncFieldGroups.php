<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF\Cli;

use ACF_Admin_Field_Groups;
use Kaiseki\WordPress\Hook\HookProviderInterface;
use Kaiseki\WordPress\WpCli\Util\Logger;
use WP_CLI;

use function acf_get_instance;
use function acf_get_local_json_files;
use function acf_import_field_group;
use function acf_include;
use function acf_update_setting;
use function add_action;
use function class_exists;
use function defined;
use function file_get_contents;
use function json_decode;
use function sprintf;

/**
 * @phpstan-type FieldGroup array{
 *     ID: int|string,
 *     title: string,
 * }
 */
final class SyncFieldGroups implements HookProviderInterface
{
    public const COMMAND = 'kaiseki acf-sync-field-groups';

    public function __construct(
        private Logger $logger,
    ) {
    }

    public function addHooks(): void
    {
        add_action('cli_init', [$this, 'registerCliCommand']);
    }

    public function registerCliCommand(): void
    {
        WP_CLI::add_command(
            self::COMMAND,
            [$this, 'runCommand'],
            [
                'shortdesc' => 'Sync all local JSON files to the database',
            ]
        );
    }

    public function runCommand(): void
    {
        if (!defined('WP_CLI') || !WP_CLI) {
            return;
        }

        acf_include('includes/admin/admin-internal-post-type-list.php');
        if (!class_exists('ACF_Admin_Internal_Post_Type_List')) {
            $this->logger->error('Some required ACF classes could not be found. Please update ACF to the latest version.');

            return;
        }
        acf_include('includes/admin/post-types/admin-field-groups.php');

        /**
         * @var ACF_Admin_Field_Groups $fieldGroupsClass
         */
        $fieldGroupsClass = acf_get_instance('ACF_Admin_Field_Groups');
        $fieldGroupsClass->setup_sync();

        // Disable "Local JSON" controller to prevent the .json file from being modified during import.
        acf_update_setting('json', false);

        // Sync field groups and generate array of new IDs.
        $files = acf_get_local_json_files();

        $count = 0;
        foreach ($fieldGroupsClass->sync as $key => $fieldGroup) {
            $fileContents = file_get_contents($files[$key]);
            if ($fileContents === false) {
                continue;
            }

            /** @var FieldGroup $localFieldGroup */
            $localFieldGroup = json_decode($fileContents, true);
            $localFieldGroup['ID'] = $fieldGroup['ID'];

            $importedFieldGroup = acf_import_field_group($localFieldGroup);
            $this->logger->info(sprintf('Synced ACF field group: %s', $importedFieldGroup['title']), true);
            $count++;
        }

        if ($count === 0) {
            $this->logger->info('No field groups were synced.');
        } else {
            $this->logger->success(sprintf('%d field groups synced.', $count));
        }
    }
}
