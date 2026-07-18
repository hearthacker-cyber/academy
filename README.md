# HIFI11 Academy — Premium Digital Bundle Pack Website

A complete PHP website for selling a one-time downloadable digital bundle
(NOT an LMS / course platform). Built on top of your existing `index.php`
landing page, reusing its exact design system (Bootstrap 5, glassmorphism,
gradients, AOS animations, colors, typography).

## Folder Structure

```
/
├── index.php                 (your original landing page — unchanged design)
├── checkout.php               Customer details + Razorpay order creation
├── payment-success.php        Success screen + auto customer/account creation
├── download.php                Secure, token-gated bundle download
├── login.php                  Email + OTP login (frontend + backend placeholders)
├── dashboard.php               Customer dashboard
├── my-downloads.php            All purchased bundles + version history
├── profile.php                 Edit profile + purchase history
├── support.php                  FAQ + support ticket form
├── contact.php                  Contact form + socials
├── privacy-policy.php / refund-policy.php / terms.php
├── invoice.php                  Printable / PDF-style invoice
├── logout.php
├── process-payment.php          Opens the real Razorpay Checkout popup
├── verify_payment.php           Server-side signature verification (AJAX endpoint)
├── download.php                  Login-gated "here's your bundle" info page
├── download-file.php             The ONLY file that streams bundle bytes (re-checks everything)
├── includes/
│   ├── header.php              Shared header/navbar (same design system)
│   ├── footer.php              Shared footer + floating socials
│   ├── functions.php           CSRF, validation, auth helpers
│   └── downloads.php            Download-token issuance + authorizeDownload() middleware
├── config/
│   ├── config.php               Site constants + bootstrap + SECURE_STORAGE_PATH
│   ├── database.php              PDO connection (EDIT credentials here)
│   └── razorpay.php               Real Razorpay Orders API + signature verification (EDIT keys here)
├── assets/css/style.css         Shared design system CSS (extracted from index.php)
├── database/schema.sql          Full MySQL schema + seed data
├── database/migrations/         Incremental SQL for already-deployed DBs
├── uploads/                     (empty — for any admin-uploaded assets)
└── downloads/                    (LEGACY, now unused/blocked — see below)

../hifi11-secure-storage/         (sibling of this folder, OUTSIDE the web root —
                                    put your real bundle .zip here, see its README.txt)
```

## Secure downloads — how it works now

The bundle ZIP is never reachable by a direct URL. `download-file.php`
is the only code path that reads the file off disk, and before it does,
it re-derives authorization from scratch on every single request:

1. Customer must have a logged-in session (email + OTP login) — otherwise redirect to `login.php`.
2. The download token in the URL must exist in the `download_tokens` table, be unexpired and not revoked.
3. The token's `customer_id` must match the logged-in session's customer — otherwise `403`.
4. The token's linked order must belong to that same customer and have `status = 'paid'` — otherwise `403`.
5. The token's download count must be under its limit (`DOWNLOAD_MAX_COUNT` in `config/config.php`, default 10; set to 0 for unlimited).
6. The resolved file path is validated to sit inside `SECURE_STORAGE_PATH` (blocks path traversal) and to actually exist — otherwise `404`.

Only after all of that does it `readfile()` the ZIP with `Content-Disposition: attachment`. Every completed download is logged to `download_logs` (customer, order, token, IP, user agent, bundle version, timestamp).

Tokens themselves are 64 random bytes from `random_bytes()`; only their SHA-256 hash is stored in the database, the same way you'd store a password-reset token.

## Setup

1. Create the database:
   ```
   mysql -u root -p < database/schema.sql
   ```
2. Edit `config/database.php` with your real DB host/user/password.
3. Edit `config/razorpay.php`:
   - Set `RAZORPAY_KEY_ID` / `RAZORPAY_KEY_SECRET`.
   - Replace the bodies of `createOrder()` and `verifyPayment()` with real
     Razorpay SDK calls (comments show exactly what to paste in).
   - `composer require razorpay/razorpay` is recommended.
4. Wire up real Razorpay Checkout.js on `checkout.php`: after `createOrder()`
   returns an order id, open the Razorpay Checkout modal client-side, then
   post `razorpay_payment_id` / `razorpay_order_id` / `razorpay_signature`
   to `payment-success.php` for verification (currently that page treats
   payments as pre-verified so you can test the full flow before your keys
   are ready).
5. Change the `CHANGE_THIS_SECRET_KEY` value in `config/razorpay.php`
   (used to sign download tokens) to a long random string.
6. Replace the placeholder `sendOtpPlaceholder()` / `verifyOtpPlaceholder()`
   functions in `login.php` with your real OTP service (MSG91, Twilio, etc).
7. Create `../hifi11-secure-storage/` as a sibling folder OUTSIDE your web
   root, upload your real bundle ZIP there, and make sure `bundle_versions.file_path`
   in the database is just the filename (e.g. `hifi11-bundle-v1.0.zip`) — see that
   folder's `README.txt`. If you're upgrading an existing install, run
   `database/migrations/002_secure_downloads.sql` first.
8. Hook up a real mail sender (SMTP/PHPMailer/API) anywhere you see an
   "email confirmation" comment (`payment-success.php`, `support.php`,
   `contact.php`).

## What was intentionally left as placeholders

Per your requirements, Razorpay is **not** fully integrated. Search for
`TODO` and `Replace this section with your Razorpay API` comments across
`config/razorpay.php`, `checkout.php`, and `payment-success.php`.

## Tested

Every PHP file passed `php -l` syntax checks, and the full customer journey
(checkout → auto account creation → payment success → secure token-gated
download → invoice generation, plus email+OTP login → dashboard → my
downloads → profile) was run end-to-end locally against a fresh MySQL
schema with PHP's built-in server — all pages returned HTTP 200 and the
expected data appeared correctly.
