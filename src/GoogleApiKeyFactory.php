<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

final class GoogleApiKeyFactory
{
    public function __invoke(ContainerInterface $container): GoogleApiKey
    {
        return new GoogleApiKey(Config::fromContainer($container)->string('acf.google_api_key'));
    }
}
