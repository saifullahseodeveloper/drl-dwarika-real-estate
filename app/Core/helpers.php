<?php
declare(strict_types=1);

/**
 * Global Template Helpers
 * Accessible everywhere in views and layouts without namespace prefix
 */

if (!function_exists('e')) {
    function e(?string $string): string
    {
        return htmlspecialchars((string)($string ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('format_price')) {
    function format_price(float|int|string|null $price, string $currency = 'AED'): string
    {
        $num = (float)($price ?? 0);
        return $currency . ' ' . number_format($num);
    }
}
