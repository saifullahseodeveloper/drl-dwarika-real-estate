<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class PropertyType extends Model
{
    protected static string $table = 'property_types';

    public static function getWithPropertyCount(): array
    {
        $sql = "SELECT pt.*, COUNT(p.id) as properties_count
                FROM property_types pt
                LEFT JOIN properties p ON pt.id = p.property_type_id AND p.status = 'published'
                GROUP BY pt.id
                ORDER BY pt.sort_order ASC, pt.name ASC";
        return self::db()->query($sql)->fetchAll();
    }
}
