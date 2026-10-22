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
        $appConfig = require dirname(__DIR__, 2) . '/config/app.php';
        $defaults = [
            'site_name'            => $appConfig['name'] ?? 'DRL Dwarika Real Estate L.L.C',
            'site_tagline'         => $appConfig['tagline'] ?? 'Opening Doors To Prosperity',
            'company_phone'        => $appConfig['contact']['phone'] ?? '+971 542202920',
            'company_whatsapp'     => $appConfig['contact']['whatsapp'] ?? '971542202920',
            'company_email'        => $appConfig['contact']['email'] ?? 'admin@dwarikarealestate.ae',
            'company_address'      => $appConfig['contact']['address'] ?? 'Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira Dubai, UAE',
            'rera_orn'             => $appConfig['contact']['rera_orn'] ?? '63750',
            'dld_license'          => $appConfig['contact']['ded_license'] ?? '1637547',
            'stat_properties_sold' => $appConfig['stats']['properties_sold'] ?? '100+',
            'stat_happy_clients'   => $appConfig['stats']['happy_clients'] ?? '50+',
            'stat_years_experience'=> $appConfig['stats']['years_experience'] ?? '5+',
        ];

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
            while ($row = $stmt->fetch()) {
                $val = trim((string)($row['setting_value'] ?? ''));
                if ($row['setting_key'] === 'rera_orn' && $val === '29482') {
                    $val = '63750';
                    $pdo->prepare("UPDATE site_settings SET setting_value = '63750' WHERE setting_key = 'rera_orn'")->execute();
                } elseif ($row['setting_key'] === 'dld_license' && $val === '1092831') {
                    $val = '1637547';
                    $pdo->prepare("UPDATE site_settings SET setting_value = '1637547' WHERE setting_key = 'dld_license'")->execute();
                } elseif ($row['setting_key'] === 'company_phone' && str_contains($val, '123 4567')) {
                    $val = '+971 542202920';
                    $pdo->prepare("UPDATE site_settings SET setting_value = '+971 542202920' WHERE setting_key = 'company_phone'")->execute();
                } elseif ($row['setting_key'] === 'company_whatsapp' && str_contains($val, '1234567')) {
                    $val = '971542202920';
                    $pdo->prepare("UPDATE site_settings SET setting_value = '971542202920' WHERE setting_key = 'company_whatsapp'")->execute();
                } elseif ($row['setting_key'] === 'company_email' && $val === 'info@dwarikarealestate.ae') {
                    $val = 'admin@dwarikarealestate.ae';
                    $pdo->prepare("UPDATE site_settings SET setting_value = 'admin@dwarikarealestate.ae' WHERE setting_key = 'company_email'")->execute();
                } elseif ($row['setting_key'] === 'company_address' && str_contains($val, 'Prime Tower')) {
                    $val = 'Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira Dubai, UAE';
                    $pdo->prepare("UPDATE site_settings SET setting_value = 'Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira Dubai, UAE' WHERE setting_key = 'company_address'")->execute();
                }
                $defaults[$row['setting_key']] = $val;
            }
            $this->settings = $defaults;
        } catch (\Throwable $e) {
            $this->settings = $defaults;
        }
    }
}
