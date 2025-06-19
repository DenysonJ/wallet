# Database Migration System

This directory contains the database migration system for the Wallet application.

## Files

- **DatabaseConnection.php** - Singleton class for database connections using PDO
- **MigrationRunner.php** - Handles executing and tracking database migrations
- **migrate.php** - CLI script for running migrations

## Setup

1. **Environment Configuration**
   Create a `.env` file in the project root with your database configuration:
   ```
   DB_HOST=localhost
   DB_NAME=wallet
   DB_USERNAME=root
   DB_PASSWORD=your_password
   DB_PORT=3306
   DB_CHARSET=utf8mb4
   ```

2. **Database Creation**
   Create your database first:
   ```sql
   CREATE DATABASE wallet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

## Usage

### Run Migrations
Execute all pending migrations:
```bash
php src/Infra/migrate.php run
```

### Check Migration Status
View which migrations have been executed:
```bash
php src/Infra/migrate.php status
```

### Help
View available commands:
```bash
php src/Infra/migrate.php help
```

## How It Works

1. **Migration Table**: Automatically creates a `migrations` table to track executed migrations
2. **File Ordering**: Migration files are executed in alphabetical order (00_, 01_, 02_, etc.)
3. **Transaction Safety**: Each migration runs in a transaction and rolls back on failure
4. **Idempotent**: Safe to run multiple times - only executes pending migrations

## Migration Files

The system looks for `.sql` files in the `src/database/` directory:

- `00_create_migrations_table.sql` - Creates the migrations tracking table
- `01_create_users_table.sql` - Creates the users table
- `02_create_accounts_table.sql` - Creates the accounts table
- `03_create_credit_cards_table.sql` - Creates the credit cards table
- `04_create_transactions_table.sql` - Creates the transactions table

## Features

- ✅ **MySQL 8.4 Compatible** - Uses modern MySQL features
- ✅ **Transaction Safety** - Rollback on errors
- ✅ **Migration Tracking** - Prevents duplicate execution
- ✅ **Status Reporting** - Shows executed vs pending migrations
- ✅ **Environment Support** - Configurable via .env file
- ✅ **Error Handling** - Clear error messages and proper exit codes 