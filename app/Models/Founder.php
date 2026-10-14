<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Founder extends Model
{
    protected static string $table = 'founders';

    public static function getAll(): array
    {
        $stmt = self::db()->query("SELECT * FROM " . static::$table . " ORDER BY sort_order ASC, id ASC");
        return $stmt->fetchAll();
    }

    public static function getPublished(): array
    {
        $stmt = self::db()->query("SELECT * FROM " . static::$table . " WHERE status = 'published' ORDER BY sort_order ASC, id ASC");
        return $stmt->fetchAll();
    }
}
