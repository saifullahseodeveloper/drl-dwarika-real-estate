<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected array $settings = [];

    public function __construct()
    {
        // Load cached or DB site settings
        $this->loadSettings();
    }

    protected function render(string $template, array $data = [], ?string $layout = 'layouts/main'): void
    {
        // Merge global settings & current user
        $data['settings'] = $this->settings;
        $data['currentUser'] = Session::get('admin_user');
        $data['csrf_token'] = Session::generateCsrfToken();
        
        echo View::render($template, $data, $layout);
    }

    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function validateCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        if (!Session::validateCsrfToken($token)) {
            http_response_code(419);
            die("Error 419: CSRF Token validation failed. Please refresh and try again.");
        }
    }

    private function loadSettings(): void
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
            while ($row = $stmt->fetch()) {
                $this->settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (\Throwable $e) {
            // Fallback default settings
            $appConfig = require dirname(__DIR__, 2) . '/config/app.php';
            $this->settings = [
                'site_name'            => $appConfig['name'],
                'site_tagline'         => $appConfig['tagline'],
                'company_phone'        => $appConfig['contact']['phone'],
                'company_email'        => $appConfig['contact']['email'],
                'company_address'      => $appConfig['contact']['address'],
                'stat_properties_sold' => $appConfig['stats']['properties_sold'],
                'stat_happy_clients'   => $appConfig['stats']['happy_clients'],
                'stat_years_experience'=> $appConfig['stats']['years_experience'],
            ];
        }
    }
}
