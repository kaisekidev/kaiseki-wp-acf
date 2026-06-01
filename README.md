# kaiseki/wp-acf

Advanced Custom Fields (ACF) helpers for WordPress: local JSON sync, a Google Maps API key provider, and a WP-CLI field-group sync command.

Three small pieces wired through `ConfigProvider` and driven by the `acf` config key:

- **`LocalJson`** — configures ACF's local-JSON load/save paths.
- **`GoogleApiKey`** — sets ACF's `google_api_key` setting (from config or the `GOOGLE_MAPS_API_KEY` constant).
- **`SyncFieldGroups`** — a `kaiseki acf-sync-field-groups` WP-CLI command that imports all local-JSON
  field groups into the database.

## Installation

```bash
composer require kaiseki/wp-acf
```

Requires PHP 8.2 or newer. Expects the ACF (Pro) plugin to be active at runtime.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator and configure the `acf` key:

```php
return [
    'acf' => [
        'local_json' => [
            'load_paths' => [
                get_stylesheet_directory() . '/acf-json',
            ],
            'save_path' => get_stylesheet_directory() . '/acf-json',
        ],
        'google_api_key' => 'AIza...', // or define('GOOGLE_MAPS_API_KEY', ...)
    ],
];
```

`ConfigProvider` registers factories for `LocalJson` and `GoogleApiKey`, and the `SyncFieldGroups`
WP-CLI command as a hook provider. The Google API key can also come from the `GOOGLE_MAPS_API_KEY`
constant, which takes precedence over the config value.

Sync local JSON field groups to the database:

```bash
wp kaiseki acf-sync-field-groups
```

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE).
