<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        Session::start();
        if (Session::has('admin_user')) {
            $this->redirect('/admin/dashboard');
            return;
        }

        $this->render('admin/auth/login', [
            'meta_title' => 'Admin Portal Login | DRL Dwarika Real Estate LLC',
            'error'      => Session::flash('error')
        ], null);
    }

    public function login(): void
    {
        $this->validateCsrf();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            Session::flash('error', 'Please enter both email and password.');
            $this->redirect('/admin/login');
            return;
        }

        $user = User::authenticate($email, $password);

        if (!$user) {
            Session::flash('error', 'Invalid email credentials or account inactive.');
            $this->redirect('/admin/login');
            return;
        }

        Session::set('admin_user', $user);
        Session::flash('success', "Welcome back, {$user['name']}!");
        $this->redirect('/admin/dashboard');
    }

    public function logout(): void
    {
        Session::destroy();
        $this->redirect('/admin/login');
    }
}
