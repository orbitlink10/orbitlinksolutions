-- Zivo integration tables
-- ---------------------------------------------------------------------------
-- One-off setup for a deployment where `php artisan migrate` cannot be run
-- (e.g. shared hosting with no SSH/Terminal). Equivalent to:
--   database/migrations/2026_09_28_000001_create_zivo_integration_tables.php
--
-- Apply without a shell:
--   1. Open the store's database in phpMyAdmin.
--   2. Import this file (Import tab) or paste it into the SQL tab and run.
--   3. Reload the site, then click "Sync now" in Zivo.
--
-- This fixes the symptom: GET /api/zivo/v1/products and /api/zivo/v1/store/policies
-- returning HTTP 500 for every well-formed Bearer token, because the auth
-- middleware cannot query `zivo_api_keys`.
-- ---------------------------------------------------------------------------

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `zivo_api_keys` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `key_hash` CHAR(64) NOT NULL,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  `revoked_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `zivo_api_keys_key_hash_unique` (`key_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `zivo_webhook_events` (
  `id` CHAR(36) NOT NULL,
  `store_id` VARCHAR(255) NOT NULL,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` INT UNSIGNED NOT NULL DEFAULT 0,
  `available_at` TIMESTAMP NOT NULL,
  `locked_until` TIMESTAMP NULL DEFAULT NULL,
  `delivered_at` TIMESTAMP NULL DEFAULT NULL,
  `failed_at` TIMESTAMP NULL DEFAULT NULL,
  `last_error` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zivo_webhook_events_available_at_index` (`available_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Register the migration so a later `php artisan migrate` does not try to
-- re-create the tables above.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_09_28_000001_create_zivo_integration_tables',
       COALESCE((SELECT MAX(`batch`) FROM (SELECT `batch` FROM `migrations`) AS `mx`), 0) + 1
FROM (SELECT 1) AS `d`
WHERE NOT EXISTS (
  SELECT 1 FROM (SELECT `migration` FROM `migrations`) AS `me`
  WHERE `me`.`migration` = '2026_09_28_000001_create_zivo_integration_tables'
);
