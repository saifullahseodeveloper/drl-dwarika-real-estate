<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Blog extends Model
{
    protected static string $table = 'blogs';

    public static function allPublished(string $orderBy = 'published_at DESC'): array
    {
        try {
            $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE status = 'published' ORDER BY {$orderBy}");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public static function findBySlug(string $slug): ?array
    {
        try {
            $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE slug = ? LIMIT 1");
            $stmt->execute([$slug]);
            $res = $stmt->fetch();
            return $res ?: null;
        } catch (\PDOException $e) {
            return null;
        }
    }
}
