<?php

declare(strict_types=1);

namespace Kaiseki
\WordPress\ACF;

use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;

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
        if ($this->googleApiKey === null) {
            return;
        }
        acf_update_setting('google_api_key', $this->googleApiKey);
    }
}
