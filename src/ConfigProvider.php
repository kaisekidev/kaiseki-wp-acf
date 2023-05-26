<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'aliases' => [],
                'factories' => [],
            ],
        ];
    }
}
