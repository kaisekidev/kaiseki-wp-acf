<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

use function function_exists;
use function is_plugin_active;

final class Plugin
{
    private const PLUGIN_NAME = 'advanced-custom-fields/advanced-custom-fields.php';
    private const PRO_PLUGIN_NAME = 'advanced-custom-fields-pro/advanced-custom-fields-pro.php';

    public function isActive(string $plugin = ''): bool
    {
        if (!function_exists('is_plugin_active')) {
            return false;
        }
        if ($plugin !== '') {
            return is_plugin_active($plugin);
        }
        return is_plugin_active(self::PRO_PLUGIN_NAME) || is_plugin_active(self::PLUGIN_NAME);
    }

    public function isProVersionActive(): bool
    {
        return $this->isActive(self::PRO_PLUGIN_NAME);
    }
}
