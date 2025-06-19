<?php

namespace App\Infra;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?PDO $instance = null;
    
    private function __construct() {}
    
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::createConnection();
        }
        
        return self::$instance;
    }
    
    private static function createConnection(): PDO
    {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $dbname = $_ENV['DB_NAME'] ?? 'wallet';
        $username = $_ENV['DB_USERNAME'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? '';
        $port = $_ENV['DB_PORT'] ?? 3306;
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';
        
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
        
        try {
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}"
            ]);
            
            return $pdo;
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }
} 