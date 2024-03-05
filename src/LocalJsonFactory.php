<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

use Kaiseki\Config\Config;
use Kaiseki\WordPress\Environment\Environment;
use Psr\Container\ContainerInterface;

final class LocalJsonFactory
{
    public function __invoke(ContainerInterface $container): LocalJson
    {
        $config = Config::fromContainer($container);
        /** @var list<string> $loadPaths */
        $loadPaths = $config->array('acf.local_json.load_paths');
        $savePath = $config->string('acf.local_json.save_path');

        return new LocalJson(
            $container->get(Environment::class),
            $loadPaths,
            $savePath !== '' ? $savePath : null
        );
    }
}
