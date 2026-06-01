# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-01

First tagged release.

### Added

- ACF helpers wired through `ConfigProvider` from the `acf` config key: `LocalJson` (local-JSON
  load/save paths), `GoogleApiKey` (ACF Google Maps API key, from config or the `GOOGLE_MAPS_API_KEY`
  constant), and the `kaiseki acf-sync-field-groups` WP-CLI command (`SyncFieldGroups`).

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target); declared `ext-json`.
- Modernized the dev toolchain (PHPStan 2, PHPUnit 11 schema); **added** `maglnet/composer-require-checker ^4`
  with a `check-deps` script; now depends on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan
  config (ACF Pro + WP-CLI stubs kept via `scanFiles`); `kaiseki/config`, `kaiseki/wp-hook` pinned to
  `^2.0`, `kaiseki/wp-cli-util`, `kaiseki/wp-env` to `^1.0`. CI now runs via the reusable workflow in
  `kaisekidev/.github`.

### Fixed

- PHPStan 2 (level max), at the root: narrowed the `GOOGLE_MAPS_API_KEY` constant with `is_string`, and
  in `SyncFieldGroups` narrowed ACF's loosely-typed values (`is_array`/`is_string`) instead of an inline
  `@var` over `json_decode()`. No behaviour change.
