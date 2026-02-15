# Development Guide

This document provides instructions for setting up your local development environment and understanding the SnipTools architecture.

## 💻 Local Environment Setup

1. **Requirements**:
   - PHP 7.4 or higher
   - MySQL
   - Web Server (Apache/Nginx/Local PHP server)

2. **Configuration**:
   - Copy `config/config.php.example` to `config/config.php`.
   - Update the database credentials in `config/config.php` under the `$isLocal` block.

3. **Database Setup**:
   - Create a database named `sniptools_db`.
   - Import the initial schema and data using the `schema.sql` file:
     ```bash
     mysql -u your_user -p sniptools_db < schema.sql
     ```
   - Alternatively, you can run the migration script:
     ```bash
     php scripts/migrate.php
     ```

## 🏗 Project Architecture

SnipTools uses a custom-built PHP structure that separates configuration, logic, and views.

- **Routing**: Most tools are accessible via `/views/tools/[slug].php`. Global routing typically happens through the primary entry points in `public/`.
- **Logic**: Shared functions are located in `includes/functions.php`. Database interactions are handled by `includes/db.php` using PDO.
- **Views**: The UI is composed of reusable parts in `includes/` (e.g., `header.php`, `sidebar.php`, `footer.php`) wrap around the page content in `views/`.

## 🛠 Adding a New Tool

1. Create a new PHP file in `views/tools/[category]/` or `views/tools/`.
2. Define the tool in `config/tools.php` to include it in the sidebar and home page listing.
3. Update the database by running `scripts/migrate.php`.
