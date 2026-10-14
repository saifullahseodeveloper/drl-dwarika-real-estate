<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Model
{
    protected static string $table = '';

    protected static function db(): PDO
    {
        return Database::getConnection();
    }

    public static function all(string $orderBy = 'id DESC'): array
    {
        $stmt = self::db()->query("SELECT * FROM " . static::$table . " ORDER BY " . $orderBy);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM " . static::$table . " WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM " . static::$table . " WHERE slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function count(string $where = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as cnt FROM " . static::$table;
        if (!empty($where)) {
            $sql .= " WHERE " . $where;
        }
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return (int)($stmt->fetch()['cnt'] ?? 0);
    }
}
