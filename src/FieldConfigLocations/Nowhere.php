<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF\FieldConfigLocations;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function _x;
use function add_filter;

final class Nowhere implements HookProviderInterface
{
    public function addHooks(): void
    {
        add_filter('acf/location/rule_types', [$this, 'addNowhereLocationType']);
    }

    /**
     * @param array<string, array<string, string>> $choices
     *
     * @return array<string, array<string, string>>
     */
    public static function addNowhereLocationType(array $choices = []): array
    {
        $choices['Basic']['nowhere'] = _x('Nowhere', 'kaiseki-wp-acf', 'kaiseki');
        \Safe\ksort($choices);

        return $choices;
    }
}
