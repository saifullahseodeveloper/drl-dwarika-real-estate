<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class View
{
    private static string $viewsPath = '';

    public static function init(): void
    {
        self::$viewsPath = dirname(__DIR__) . '/Views';
    }

    public static function render(string $template, array $data = [], ?string $layout = 'layouts/main'): string
    {
        if (empty(self::$viewsPath)) {
            self::init();
        }

        $templateFile = self::$viewsPath . '/' . ltrim($template, '/') . '.php';
        if (!file_exists($templateFile)) {
            throw new RuntimeException("View template not found: {$templateFile}");
        }

        // Extract variables to local scope
        extract($data, EXTR_SKIP);

        // Capture content
        ob_start();
        require $templateFile;
        $content = ob_get_clean();

        // If layout specified, render wrapped inside layout
        if ($layout !== null) {
            $layoutFile = self::$viewsPath . '/' . ltrim($layout, '/') . '.php';
            if (!file_exists($layoutFile)) {
                throw new RuntimeException("Layout template not found: {$layoutFile}");
            }
            ob_start();
            require $layoutFile;
            return ob_get_clean();
        }

        return $content;
    }

    public static function component(string $name, array $data = []): void
    {
        if (empty(self::$viewsPath)) {
            self::init();
        }
        $file = self::$viewsPath . '/components/' . ltrim($name, '/') . '.php';
        if (file_exists($file)) {
            extract($data, EXTR_SKIP);
            require $file;
        }
    }

    public static function escape(?string $string): string
    {
        return htmlspecialchars((string)$string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// Global helper function for concise escaping in templates
if (!function_exists('e')) {
    function e(?string $string): string
    {
        return \App\Core\View::escape($string);
    }
}

// Global helper for formatting AED currency
if (!function_exists('format_price')) {
    function format_price(float|int|string $price, string $currency = 'AED'): string
    {
        $num = (float)$price;
        return $currency . ' ' . number_format($num);
    }
}
