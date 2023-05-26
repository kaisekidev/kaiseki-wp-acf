<?php

declare(strict_types=1);

namespace Kaiskei\WordPress\Acf;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'acf' => [
                'local_json' => [
                    'load_paths' => [],
                    'save_path' => '',
                ],
                'google_api_key' => '',
            ],
            'dependencies' => [
                'factories' => [
                    LocalJson::class => LocalJsonFactory::class,
                    GoogleApiKey::class => GoogleApiKeyFactory::class,
                ],
            ],
        ];
    }
}
