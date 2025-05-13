<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

use Kaiseki\WordPress\ACF\Cli\SyncFieldGroups;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'acf' => [
                'local_json' => [
                    'load_paths' => [],
                    'save_path' => '',
                ],
                'google_api_key' => '',
            ],
            'hook' => [
                'provider' => [
                    SyncFieldGroups::class,
                ],
            ],
            'dependencies' => [
                'factories' => [
                    LocalJson::class => LocalJsonFactory::class,
                    GoogleApiKey::class => GoogleApiKeyFactory::class,
                ],
            ],
        ];
    }
}
