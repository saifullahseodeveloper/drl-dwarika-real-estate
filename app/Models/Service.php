<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Service extends Model
{
    protected static string $table = 'services';

    public static function getActive(): array
    {
        $sql = "SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC, id ASC";
        return self::db()->query($sql)->fetchAll();
    }
}
