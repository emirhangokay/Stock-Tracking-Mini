<?php

declare(strict_types=1);

namespace Src\Services;

use Src\Models\UserModel;

class AuthService
{
    public function __construct(private readonly UserModel $users)
    {
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);
        if (!$user) {
            return false;
        }

        if ((int)$user['is_active'] !== 1) {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
    }
}
