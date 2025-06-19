<?php

namespace App\Infra;

use PDO;
use PDOException;

class MigrationRunner
{
    private PDO $pdo;
    private string $migrationsPath;
    
    public function __construct(PDO $pdo, string $migrationsPath)
    {
        $this->pdo = $pdo;
        $this->migrationsPath = $migrationsPath ?? __DIR__ . '/../database/';
    }
    
    public function run(): void
    {
        echo "Starting migrations...\n";
        
        // Ensure migrations table exists
        $this->createMigrationsTable();
        
        // Get all migration files
        $migrationFiles = $this->getMigrationFiles();
        
        if (empty($migrationFiles)) {
            echo "No migration files found.\n";
            return;
        }
        
        // Get already executed migrations
        $executedMigrations = $this->getExecutedMigrations();
        
        $executed = 0;
        foreach ($migrationFiles as $file) {
            $migrationName = basename($file, '.sql');
            
            if (in_array($migrationName, $executedMigrations)) {
                echo "Skipping already executed migration: {$migrationName}\n";
                continue;
            }
            
            echo "Executing migration: {$migrationName}\n";
            
            try {
                $this->executeMigration($file, $migrationName);
                $executed++;
                echo "✓ Migration {$migrationName} executed successfully\n";
            } catch (\Throwable $e) {
                echo "✗ Migration {$migrationName} failed: " . $e->getMessage() . "\n";
                throw $e;
            }
        }
        
        echo "\nMigrations completed. Executed: {$executed}\n";
    }
    
    private function createMigrationsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT PRIMARY KEY AUTO_INCREMENT,
            migration_name VARCHAR(255) NOT NULL UNIQUE,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_migration_name (migration_name)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $this->pdo->exec($sql);
    }
    
    private function getMigrationFiles(): array
    {
        $files = glob($this->migrationsPath . '*.sql');
        sort($files); // Ensure files are executed in order
        return $files;
    }
    
    private function getExecutedMigrations(): array
    {
        $stmt = $this->pdo->query("SELECT migration_name FROM migrations ORDER BY executed_at");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    private function executeMigration(string $filePath, string $migrationName): void
    {
        $sql = file_get_contents($filePath);
        
        if ($sql === false) {
            throw new \RuntimeException("Failed to read migration file: {$filePath}");
        }
        
        // Remove comments and empty lines
        $sql = preg_replace('/^\s*--.*$/m', '', $sql);
        $sql = preg_replace('/^\s*$/m', '', $sql);
        $sql = trim($sql);
        
        if (empty($sql)) {
            throw new \RuntimeException("Migration file is empty: {$filePath}");
        }
        
        try {
            // Execute the migration (DDL statements auto-commit in MySQL)
            $this->pdo->exec($sql);
            
            // Record the migration as executed (in a separate transaction)
            $stmt = $this->pdo->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
            $stmt->execute([$migrationName]);
            
        } catch (\Throwable $e) {
            // For DDL statements, we can't rollback since they auto-commit
            // The migration tracking insert might fail, but the schema change has already happened
            throw new \RuntimeException("Migration failed: " . $e->getMessage() . " (Note: DDL changes may have been applied)");
        }
    }
    
    public function status(): void
    {
        echo "Migration Status:\n";
        echo "================\n";
        
        $this->createMigrationsTable();
        
        $migrationFiles = $this->getMigrationFiles();
        $executedMigrations = $this->getExecutedMigrations();
        
        foreach ($migrationFiles as $file) {
            $migrationName = basename($file, '.sql');
            $status = in_array($migrationName, $executedMigrations) ? '✓ Executed' : '✗ Pending';
            echo "{$status}: {$migrationName}\n";
        }
        
        echo "\nTotal migrations: " . count($migrationFiles) . "\n";
        echo "Executed: " . count($executedMigrations) . "\n";
        echo "Pending: " . (count($migrationFiles) - count($executedMigrations)) . "\n";
    }
} 