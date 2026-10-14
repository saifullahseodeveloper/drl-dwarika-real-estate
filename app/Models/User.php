<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected static string $table = 'users';

    public static function authenticate(string $email, string $password): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM users WHERE email = :email AND status = 'active' LIMIT 1");
        $stmt->execute(['email' => strtolower(trim($email))]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Update last login
            $update = self::db()->prepare("UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE id = :id");
            $update->execute(['id' => $user['id']]);
            
            unset($user['password_hash']);
            return $user;
        }

        return null;
    }
}
