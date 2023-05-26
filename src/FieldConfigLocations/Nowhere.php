<?php

declare(strict_types=1);

namespace Kaiskei\WordPress\Acf\FieldConfigLocations;

use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;

use function add_filter;

final class Nowhere implements HookCallbackProviderInterface
{
    public function registerHookCallbacks(): void
    {
        add_filter('acf/location/rule_types', [$this, 'addNowhereLocationType']);
    }

    /**
     * @param array<string, array<string, string>> $choices
     * @return array<string, array<string, string>>
     */
    public static function addNowhereLocationType(array $choices = []): array
    {
        $choices['Basic']['nowhere'] = _x('Nowhere', 'kaiseki-wp-acf', 'kaiseki');
        \Safe\ksort($choices);
        return $choices;
    }
}
