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
        $c = $config['connections']['mysql'] ?? [];
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $c['host'] ?? '127.0.0.1',
            (int) ($c['port'] ?? 3306),
            $c['database'] ?? 'nyautwa',
            $c['charset'] ?? 'utf8mb4'
        );

        try {
            $this->connection = new PDO($dsn, (string)($c['username'] ?? 'root'), (string)($c['password'] ?? ''), $c['options'] ?? [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            $msg = "Koneksi Database MySQL Gagal: " . $e->getMessage() . 
                   ". Pastikan pengaturan DB_HOST, DB_DATABASE, DB_USERNAME, dan DB_PASSWORD di file .env sudah sesuai.";
            error_log($msg);
            throw new RuntimeException($msg, (int) $e->getCode(), $e);
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
