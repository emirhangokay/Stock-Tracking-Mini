<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\UserModel;
use Src\Services\AuthService;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (is_logged_in()) {
            $this->redirect('dashboard');
        }
        $this->render('auth/login', ['title' => 'Giris Yap']);
    }

    public function login(): void
    {
        $email = trim((string)input('email', ''));
        $password = (string)input('password', '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            flash('danger', 'E-posta veya sifre gecersiz.');
            $this->redirect('login');
        }

        $service = new AuthService(new UserModel(db()));
        if (!$service->attempt($email, $password)) {
            flash('danger', 'E-posta veya sifre hatali.');
            audit('login_failed', 'users', null, 'Email: ' . $email);
            $this->redirect('login');
        }

        audit('login_success', 'users', user_id(), 'Basarili giris');
        flash('success', 'Hos geldiniz.');
        $this->redirect('dashboard');
    }

    public function logout(): void
    {
        (new AuthService(new UserModel(db())))->logout();
        flash('info', 'Cikis yapildi.');
        $this->redirect('login');
    }
}
