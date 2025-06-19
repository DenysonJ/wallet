<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infra\DatabaseConnection;
use App\Infra\MigrationRunner;

// Load environment variables if .env file exists
if (file_exists(__DIR__ . '/../../.env')) {
    $lines = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

function showHelp(): void
{
    echo "Wallet Migration Tool\n";
    echo "====================\n\n";
    echo "Usage: php migrate.php [command]\n\n";
    echo "Commands:\n";
    echo "  run     - Run pending migrations\n";
    echo "  status  - Show migration status\n";
    echo "  help    - Show this help message\n\n";
    echo "Environment Variables:\n";
    echo "  DB_HOST     - Database host (default: localhost)\n";
    echo "  DB_NAME     - Database name (default: wallet)\n";
    echo "  DB_USERNAME - Database username (default: root)\n";
    echo "  DB_PASSWORD - Database password (default: empty)\n";
    echo "  DB_PORT     - Database port (default: 3306)\n";
    echo "  DB_CHARSET  - Database charset (default: utf8mb4)\n";
}

function main(): void
{
    global $argv;
    $command = $argv[1] ?? 'help';
    
    try {
        switch ($command) {
            case 'run':
                echo "🚀 Running migrations...\n\n";
                $pdo = DatabaseConnection::getInstance();
                $runner = new MigrationRunner($pdo, __DIR__ . '/../database/');
                $runner->run();
                break;
                
            case 'status':
                echo "📊 Checking migration status...\n\n";
                $pdo = DatabaseConnection::getInstance();
                $runner = new MigrationRunner($pdo, __DIR__ . '/../database/');
                $runner->status();
                break;
                
            case 'help':
            default:
                showHelp();
                break;
        }
    } catch (\Throwable $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

main(); 