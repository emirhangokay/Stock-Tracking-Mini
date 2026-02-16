<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\UserModel;

class UserController extends Controller
{
    public function index(): void
    {
        $users = (new UserModel(db()))->all();
        $this->render('users/index', [
            'title' => 'Kullanici Yonetimi',
            'users' => $users,
        ]);
    }

    public function create(): void
    {
        $this->render('users/create', ['title' => 'Kullanici Ekle']);
    }

    public function store(): void
    {
        $name = trim((string)input('name', ''));
        $email = trim((string)input('email', ''));
        $role = (string)input('role', 'Personel');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($role, ['Admin', 'Personel'], true)) {
            flash('danger', 'Girdiler gecersiz.');
            $this->redirect('users.create');
        }

        $defaultPassword = env('DEFAULT_RESET_PASSWORD', '123456');
        $hash = password_hash($defaultPassword, PASSWORD_DEFAULT);

        try {
            $id = (new UserModel(db()))->create($name, $email, $hash, $role);
            audit('user_create', 'users', $id, 'Yeni kullanici olusturuldu');
            flash('success', 'Kullanici eklendi. Varsayilan sifre: ' . $defaultPassword);
        } catch (\Throwable $e) {
            flash('danger', 'Kullanici eklenemedi: ' . $e->getMessage());
        }

        $this->redirect('users');
    }

    public function toggleActive(): void
    {
        $id = (int)input('id', 0);
        if ($id <= 0) {
            flash('danger', 'Gecersiz kullanici.');
            $this->redirect('users');
        }

        if (user_id() === $id) {
            flash('warning', 'Kendi hesabinizi pasif yapamazsiniz.');
            $this->redirect('users');
        }

        (new UserModel(db()))->toggleActive($id);
        audit('user_toggle_active', 'users', $id, 'Kullanici aktiflik durumu degistirildi');
        flash('success', 'Kullanici durumu guncellendi.');
        $this->redirect('users');
    }

    public function resetPassword(): void
    {
        $id = (int)input('id', 0);
        if ($id <= 0) {
            flash('danger', 'Gecersiz kullanici.');
            $this->redirect('users');
        }

        $password = env('DEFAULT_RESET_PASSWORD', '123456');
        (new UserModel(db()))->resetPassword($id, password_hash($password, PASSWORD_DEFAULT));
        audit('user_reset_password', 'users', $id, 'Sifre sifirlandi');
        flash('success', 'Sifre sifirlandi. Yeni sifre: ' . $password);
        $this->redirect('users');
    }
}
