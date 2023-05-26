<?php

declare(strict_types=1);

namespace Kaiskei\WordPress\Acf;

use Kaiseki\Config\Config;
use Kaiseki\WordPress\Environment\Environment;
use Psr\Container\ContainerInterface;

final class LocalJsonFactory
{
    public function __invoke(ContainerInterface $container): LocalJson
    {
        $config = Config::get($container);
        /** @var list<string> $loadPaths */
        $loadPaths = $config->array('acf/local_json/load_paths', []);
        return new LocalJson(
            $container->get(Environment::class),
            $loadPaths,
            $config->string('acf/local_json/save_path', null)
        );
    }
}
