<?php

declare(strict_types=1);

namespace Kaiskei\WordPress\Acf;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

final class GoogleApiKeyFactory
{
    public function __invoke(ContainerInterface $container): GoogleApiKey
    {
        return new GoogleApiKey(Config::get($container)->string('acf/google_api_key', null));
    }
}
