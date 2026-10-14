<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Testimonial extends Model
{
    protected static string $table = 'testimonials';

    public static function getFeatured(): array
    {
        $sql = "SELECT * FROM testimonials WHERE is_featured = 1 ORDER BY sort_order ASC, id ASC";
        return self::db()->query($sql)->fetchAll();
    }
}
