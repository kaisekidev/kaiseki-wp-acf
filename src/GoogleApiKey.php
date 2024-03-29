<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function acf_update_setting;
use function add_action;
use function defined;

final class GoogleApiKey implements HookProviderInterface
{
    public function __construct(private readonly ?string $googleApiKey)
    {
    }

    public function addHooks(): void
    {
        add_action('acf/init', [$this, 'addGoogleApiKey']);
    }

    public function addGoogleApiKey(): void
    {
        $key = $this->getGoogleApiKey();
        if ($key === null) {
            return;
        }
        acf_update_setting('google_api_key', $key);
    }

    public function getGoogleApiKey(): ?string
    {
        if (defined('GOOGLE_MAPS_API_KEY')) {
            return GOOGLE_MAPS_API_KEY;
        }
        if ($this->googleApiKey !== null && $this->googleApiKey !== '') {
            return $this->googleApiKey;
        }

        return null;
    }
}
