-- =========================================================
-- HIFI11 ACADEMY — DATABASE SCHEMA
-- MySQL 8+ / MariaDB 10.4+
-- =========================================================

CREATE DATABASE IF NOT EXISTS hifi11_academy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hifi11_academy;

-- ---------------------------------------------------------
-- customers: created automatically after first purchase
-- ---------------------------------------------------------
CREATE TABLE customers (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name     VARCHAR(150) NOT NULL,
    email         VARCHAR(190) NOT NULL,
    mobile        VARCHAR(15)  NOT NULL,
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_email (email)
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- orders: one row per successful/attempted payment
-- ---------------------------------------------------------
CREATE TABLE orders (
    id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id           INT UNSIGNED NOT NULL,
    razorpay_order_id     VARCHAR(100) NOT NULL,
    razorpay_payment_id   VARCHAR(100) DEFAULT NULL,
    amount                DECIMAL(10,2) NOT NULL,
    currency              VARCHAR(10) NOT NULL DEFAULT 'INR',
    status                ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
    created_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_customer (customer_id),
    KEY idx_status (status),
    CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- bundle_versions: version history of the digital bundle
-- ---------------------------------------------------------
CREATE TABLE bundle_versions (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    version        VARCHAR(20) NOT NULL,
    file_path      VARCHAR(255) NOT NULL DEFAULT '',
    file_size_mb   INT UNSIGNED DEFAULT NULL,
    release_notes  TEXT,
    is_current     TINYINT(1) NOT NULL DEFAULT 0,
    released_at    DATE NOT NULL,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_version (version)
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- downloads: (optional) individual files inside a bundle version
-- ---------------------------------------------------------
CREATE TABLE downloads (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bundle_version_id   INT UNSIGNED NOT NULL,
    file_name           VARCHAR(255) NOT NULL,
    file_path           VARCHAR(255) NOT NULL,
    file_size_mb         INT UNSIGNED DEFAULT NULL,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_bundle_version (bundle_version_id),
    CONSTRAINT fk_downloads_version FOREIGN KEY (bundle_version_id) REFERENCES bundle_versions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- download_tokens: opaque, random, revocable, DB-backed tokens.
-- Only the SHA-256 hash of the raw token is stored (never the raw
-- token itself) — mirrors how password-reset tokens should be stored.
-- A token is scoped to exactly one customer + one paid order.
-- ---------------------------------------------------------
CREATE TABLE download_tokens (
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

-- ---------------------------------------------------------
-- download_logs: audit trail of every completed download
-- ---------------------------------------------------------
CREATE TABLE download_logs (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id    INT UNSIGNED NOT NULL,
    order_id       INT UNSIGNED NOT NULL,
    token_id       INT UNSIGNED DEFAULT NULL,
    bundle_version VARCHAR(20) DEFAULT NULL,
    ip_address     VARCHAR(45) DEFAULT NULL,
    user_agent     VARCHAR(255) DEFAULT NULL,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_customer (customer_id),
    KEY idx_order (order_id),
    CONSTRAINT fk_logs_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_logs_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- otp_requests: tracks OTP login attempts (once you plug in a real OTP service)
-- ---------------------------------------------------------
CREATE TABLE otp_requests (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email         VARCHAR(190) NOT NULL,
    otp_hash      VARCHAR(255) NOT NULL,
    attempts      TINYINT UNSIGNED NOT NULL DEFAULT 0,
    expires_at    DATETIME NOT NULL,
    verified_at   DATETIME DEFAULT NULL,
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_email (email)
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Seed data: initial bundle version so pages have something to show
-- NOTE: file_path is now relative to SECURE_STORAGE_PATH (defined in
-- config/config.php), which lives OUTSIDE the public web root — NOT
-- the old public /downloads/ folder. See includes/downloads.php.
-- ---------------------------------------------------------
INSERT INTO bundle_versions (version, file_path, file_size_mb, release_notes, is_current, released_at)
VALUES ('v1.0', 'hifi11-bundle-v1.0.zip', 4200, 'Initial launch release — 2 complete courses.', 1, CURDATE());
