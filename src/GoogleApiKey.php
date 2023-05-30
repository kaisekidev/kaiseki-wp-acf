<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\ACF;

use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;

use function defined;

final class GoogleApiKey implements HookCallbackProviderInterface
{
    public function __construct(private readonly ?string $googleApiKey)
    {
    }

    public function registerHookCallbacks(): void
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
