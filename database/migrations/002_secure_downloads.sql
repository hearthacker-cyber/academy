-- =========================================================
-- Migration 002: Secure download system
-- Run this against an existing hifi11_academy database that was
-- created from an older copy of schema.sql (before download_tokens
-- existed). Safe to skip if you're installing schema.sql fresh.
-- =========================================================
USE hifi11_academy;

CREATE TABLE IF NOT EXISTS download_tokens (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id       INT UNSIGNED NOT NULL,
    order_id          INT UNSIGNED NOT NULL,
    token_hash        CHAR(64) NOT NULL COMMENT 'sha256(raw 64-byte token)',
    max_downloads     SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 = unlimited',
    download_count    SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    expires_at         DATETIME NOT NULL,
    revoked_at         DATETIME DEFAULT NULL,
    created_at         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_token_hash (token_hash),
    KEY idx_customer (customer_id),
    KEY idx_order (order_id),
    CONSTRAINT fk_dltokens_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_dltokens_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Add the new columns to download_logs if they don't already exist.
-- (MySQL/MariaDB don't support IF NOT EXISTS on ADD COLUMN uniformly
-- across versions, so check information_schema first if this errors.)
ALTER TABLE download_logs ADD COLUMN token_id INT UNSIGNED DEFAULT NULL AFTER order_id;
ALTER TABLE download_logs ADD COLUMN bundle_version VARCHAR(20) DEFAULT NULL AFTER token_id;
ALTER TABLE download_logs ADD COLUMN user_agent VARCHAR(255) DEFAULT NULL AFTER ip_address;

-- bundle_versions.file_path values written under the old scheme were
-- relative to the public /downloads/ folder (e.g. "downloads/x.zip").
-- Strip that prefix now that file_path is relative to SECURE_STORAGE_PATH.
UPDATE bundle_versions SET file_path = SUBSTRING(file_path, 11)
WHERE file_path LIKE 'downloads/%';
