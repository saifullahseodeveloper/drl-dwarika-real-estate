<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class SettingsController extends Controller
{
    public function index(): void
    {
        $this->render('admin/settings/index', [
            'meta_title' => 'Global Site Settings | DRL Dwarika Admin',
            'activeNav'  => 'settings'
        ], 'layouts/admin');
    }

    public function update(): void
    {
        $this->validateCsrf();
        $db = Database::getConnection();

        $allowedKeys = [
            'site_name', 'site_tagline', 'company_phone', 'company_email',
            'company_whatsapp', 'company_address', 'rera_orn', 'dld_license',
            'stat_properties_sold', 'stat_happy_clients', 'stat_years_experience',
            'social_facebook', 'social_instagram', 'social_linkedin', 'social_youtube'
        ];

        $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group)
                              VALUES (:k, :v, 'general')
                              ON DUPLICATE KEY UPDATE setting_value = :v2");

        // Handle sqlite upsert if using sqlite
        $isSqlite = Database::getDriver() === 'sqlite';
        if ($isSqlite) {
            $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group)
                                  VALUES (:k, :v, 'general')
                                  ON CONFLICT(setting_key) DO UPDATE SET setting_value = :v2");
        }

        foreach ($allowedKeys as $key) {
            if (isset($_POST[$key])) {
                $val = trim($_POST[$key]);
                $stmt->execute(['k' => $key, 'v' => $val, 'v2' => $val]);
            }
        }

        Session::flash('success', 'Site settings updated successfully!');
        $this->redirect('/admin/settings');
    }
}
