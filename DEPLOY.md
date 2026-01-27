# Deployment Guide - SnipTools

Follow these steps to move your SnipTools app to a live server (Shared Hosting, VPS, etc.).

## 1. Database Migration

1.  **Export Local Data**:
    A full backup of your local database has been created at:
    `web/full_backup.sql`
    *(This includes all your tools, settings, users, and categories).*

2.  **Import to Live Server**:
    *   Log in to your hosting Control Panel (cPanel, Plesk, etc.).
    *   Create a new MySQL Database (e.g., `myuser_sniptools`).
    *   Create a Database User (e.g., `myuser_admin`) and Password.
    *   Open **phpMyAdmin**.
    *   Select your new database.
    *   Click **Import** and upload `web/full_backup.sql`.

## 2. File Upload

1.  **Zip the `web` folder**:
    Compress the contents of the `web` folder.
    *(Do not upload the `database.sqlite` if it exists, it's no longer needed).*

2.  **Upload**:
    *   Upload the Zip file to your server's `public_html` (or subdomain folder).
    *   Extract the Zip.

3.  **Directory Structure**:
    Your server files should look like this:
    ```
    /public_html
       /config
       /includes
       /public
       /scripts
       /views
       ...
    ```

4.  **Point Domain**:
    *   **Recommended**: Point your domain to the `public_html/public` folder.
    *   **Alternative**: If you can't change the document root, you may need to move the contents of `public` up one level or use `.htaccess` rewrites.

## 3. Configuration

1.  **Edit `config/config.php`**:
    Update the database credentials with your live server details:

    ```php
    // Database Configuration
    define('DB_DRIVER', 'mysql');
    define('DB_HOST', 'localhost'); // Usually localhost, check your host
    define('DB_NAME', 'your_live_db_name');
    define('DB_USER', 'your_live_db_user');
    define('DB_PASS', 'your_live_db_password');
    ```

2.  **Base URL**:
    Ensure the `BASE_URL` logic in `config/config.php` is correct. It typically auto-detects, but if you are in a subfolder, check it.

    ```php
    // Usually fine to leave dynamic:
    $protocol = isset($_SERVER['HTTPS']) ...
    ```

## 4. Permissions

Ensure the following folders are writable (`755` or `775` usually, sometimes `777` depending on host):
*   `web/public/` (for assets if any)

## 5. Final Checks

1.  Visit your domain.
2.  Login to `/admin` using your updated password.
3.  Check if Ads are displaying (might take 24-48h for new domains).
