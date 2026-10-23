<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    private static ?self $instance = null;
    private ?PDO $connection = null;

    private function __construct() {
        $config = require dirname(__DIR__, 2) . '/config/database.php';
        $defaultConn = $config['default'] ?? 'mysql';

        // Try configured primary connection
        if ($defaultConn === 'mysql') {
            try {
                $c = $config['connections']['mysql'];
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $c['host'],
                    $c['port'],
                    $c['database'],
                    $c['charset']
                );
                $this->connection = new PDO($dsn, $c['username'], $c['password'], $c['options']);
            } catch (PDOException $e) {
                // If MySQL connection fails (e.g. database not created yet or service off), try SQLite fallback
                error_log("MySQL connection failed: " . $e->getMessage() . ". Attempting SQLite fallback.");
                $sqlitePath = $config['connections']['sqlite']['database'];
                $sqliteDir = dirname($sqlitePath);
                if (!is_dir($sqliteDir)) {
                    mkdir($sqliteDir, 0777, true);
                }
                $this->connection = new PDO('sqlite:' . $sqlitePath, null, null, $config['connections']['sqlite']['options']);
            }
        } else {
            $sqlitePath = $config['connections']['sqlite']['database'];
            $sqliteDir = dirname($sqlitePath);
            if (!is_dir($sqliteDir)) {
                mkdir($sqliteDir, 0777, true);
            }
            $this->connection = new PDO('sqlite:' . $sqlitePath, null, null, $config['connections']['sqlite']['options']);
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }

    public static function query(string $sql, array $params = []): \PDOStatement {
        $stmt = self::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = []): array {
        return self::query($sql, $params)->fetchAll();
    }

    public static function fetchOne(string $sql, array $params = []): ?array {
        $result = self::query($sql, $params)->fetch();
        return $result ?: null;
    }

    public static function execute(string $sql, array $params = []): bool {
        return self::query($sql, $params)->rowCount() > 0;
    }

    public static function lastInsertId(): string {
        return self::getInstance()->getConnection()->lastInsertId();
    }
}
