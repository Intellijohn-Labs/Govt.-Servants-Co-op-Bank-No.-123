<?php
declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

/**
 * PDO Database wrapper enforcing prepared statements,
 * transaction helpers, and multi-driver support (MySQL primary, SQLite support).
 */
class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $driver = $_ENV['DB_DRIVER'] ?? 'mysql';

        try {
            if ($driver === 'sqlite') {
                $dbPath = $_ENV['DB_DATABASE'] ?? dirname(__DIR__) . '/storage/database.sqlite';
                $dir = dirname($dbPath);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                self::$pdo = new PDO("sqlite:{$dbPath}", null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
                self::$pdo->exec('PRAGMA foreign_keys = ON;');
            } else {
                $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
                $port = $_ENV['DB_PORT'] ?? '3306';
                $dbName = $_ENV['DB_DATABASE'] ?? 'services_coop_bank';
                $username = $_ENV['DB_USERNAME'] ?? 'root';
                $password = $_ENV['DB_PASSWORD'] ?? '';
                $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

                $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset={$charset}";

                self::$pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset} COLLATE {$charset}_unicode_ci",
                ]);
            }
        } catch (PDOException $e) {
            // Log error safely without exposing credentials
            error_log('Database Connection Error: ' . $e->getMessage());

            // If MySQL failed and we are in development, check if SQLite fallback is desired
            if (($driver === 'mysql') && (($_ENV['APP_ENV'] ?? 'production') === 'development' || isset($_ENV['ALLOW_SQLITE_FALLBACK']))) {
                try {
                    $sqlitePath = dirname(__DIR__) . '/storage/database.sqlite';
                    $dir = dirname($sqlitePath);
                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }
                    self::$pdo = new PDO("sqlite:{$sqlitePath}", null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                    self::$pdo->exec('PRAGMA foreign_keys = ON;');
                    return self::$pdo;
                } catch (\Throwable $ex) {
                    throw new \RuntimeException("Database connection failed: " . $e->getMessage());
                }
            }

            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }

        return self::$pdo;
    }

    public static function setPdo(PDO $pdo): void
    {
        self::$pdo = $pdo;
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $pdo = self::connect();
        if ($pdo->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'sqlite') {
            $sql = str_ireplace('INSERT IGNORE INTO', 'INSERT OR IGNORE INTO', $sql);
            $sql = str_ireplace('NOW()', "datetime('now')", $sql);
            $sql = str_ireplace('CURDATE()', "date('now')", $sql);
            $sql = preg_replace('/DATE_ADD\(NOW\(\),\s*INTERVAL\s+(\d+)\s+DAY\)/i', "datetime('now', '+\$1 days')", $sql);
            if (preg_match('/ON DUPLICATE KEY UPDATE/i', $sql)) {
                $sql = preg_replace('/ON DUPLICATE KEY UPDATE.*/i', '', $sql);
                $sql = str_ireplace('INSERT INTO', 'INSERT OR REPLACE INTO', $sql);
            }
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = self::query($sql, $params);
        $result = $stmt->fetch();
        return $result === false ? null : $result;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll();
    }

    public static function execute(string $sql, array $params = []): int
    {
        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
    }

    public static function lastInsertId(): string
    {
        return self::connect()->lastInsertId();
    }

    public static function transaction(callable $callback): mixed
    {
        $pdo = self::connect();
        $pdo->beginTransaction();

        try {
            $result = $callback($pdo);
            $pdo->commit();
            return $result;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
