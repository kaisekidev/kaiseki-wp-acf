<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

use Kaiseki\WordPress\Environment\EnvironmentInterface;
use Kaiseki\WordPress\Hook\HookProviderInterface;
use RuntimeException;
use Safe\Exceptions\FilesystemException;

use function add_filter;
use function array_merge;
use function count;
use function file_exists;

final class LocalJson implements HookProviderInterface
{
    /**
     * @param EnvironmentInterface $environment
     * @param list<string>         $loadPaths
     * @param ?string              $savePath
     */
    public function __construct(
        private readonly EnvironmentInterface $environment,
        private readonly array $loadPaths,
        private readonly ?string $savePath
    ) {
    }

    /**
     * @throws FilesystemException
     */
    public function addHooks(): void
    {
        if (count($this->loadPaths) > 0) {
            $this->checkLoadPathProtection();
            add_filter('acf/settings/load_json', [$this, 'addLoadPaths']);
        }
        if ($this->savePath === null || $this->savePath === '') {
            return;
        }
        $this->createFolder($this->savePath);
        add_filter('acf/settings/save_json', [$this, 'setSavePath']);
    }

    /**
     * @param array<string> $paths
     *
     * @return array<string>
     */
    public function addLoadPaths(array $paths = []): array
    {
        return array_merge($paths, $this->loadPaths);
    }

    public function setSavePath(string $path): ?string
    {
        if (!$this->environment->isDevelopment() && !$this->environment->isLocal()) {
            return null;
        }

        return $this->savePath !== '' ? $this->savePath : $path;
    }

    private function checkLoadPathProtection(): void
    {
        foreach ($this->loadPaths as $path) {
            $filename = $path . '/index.php';
            if (file_exists($filename)) {
                continue;
            }

            throw new RuntimeException('index.php missing from acf load path "' . $path . '"');
        }
    }

    /**
     * @param string $path
     *
     * @throws FilesystemException
     */
    private function createFolder(string $path): void
    {
        if (file_exists($path)) {
            return;
        }
        \Safe\mkdir($path, 0777, true);
    }
}
