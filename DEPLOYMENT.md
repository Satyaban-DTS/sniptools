# Deployment Guide

Follow these steps to deploy SnipTools to a production environment (optimized for Hostinger).

## 🌍 Server Requirements

- PHP 7.4+
- MySQL Support
- Mod_Rewrite enabled (if using custom .htaccess)

## 🚢 Deployment Process

1. **Upload Files**:
   Upload all project files to your server (e.g., using FTP/SCP or File Manager).

2. **Database Migration**:
   - Export your local database or use the provided `full_backup.sql`.
   - Upload `full_backup.sql` and `public/server_migration.php` to the server.
   - Access `yourdomain.com/server_migration.php?key=mysecret` to trigger the import.
   - > [!IMPORTANT]
     > Delete `full_backup.sql` and `server_migration.php` immediately after migration.

3. **Configuration**:
   - Edit `config/config.php` on the server.
   - Ensure the database credentials in the `else` block (for production) are correct.
   - Update `BASE_URL` to match your production domain.

4. **Permissions**:
   - Ensure the server has read/write permissions for necessary directories (e.g., if any tool requires file uploads).

## 🔍 Verification

- Visit the home page to ensure it loads correctly.
- Test a few tools (e.g., Case Converter, JSON Formatter) to verify database connectivity and logic.
- Log in to the admin panel (usually `/admin`) using the default credentials.


## Start PHP Server: Run the built-in PHP server from the project root:
- `php -S localhost:8000 -t public`


## Demo Admin credentials
- Username: `admin`
- Password: `admin123` or `Satya@2026`