<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Location extends Model
{
    protected static string $table = 'locations';

    public static function getWithPropertyCount(): array
    {
        $sql = "SELECT l.*, COUNT(p.id) as properties_count
                FROM locations l
                LEFT JOIN properties p ON l.id = p.location_id AND p.status = 'published'
                GROUP BY l.id
                ORDER BY l.is_featured DESC, l.name ASC";
        return self::db()->query($sql)->fetchAll();
    }
}
