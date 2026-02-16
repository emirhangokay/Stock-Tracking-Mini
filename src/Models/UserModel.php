<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;

class UserModel
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        return $this->pdo->query('SELECT * FROM users ORDER BY id DESC')->fetchAll();
    }

    public function create(string $name, string $email, string $passwordHash, string $role): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password_hash, role, is_active, created_at, updated_at)
             VALUES (:name, :email, :password_hash, :role, 1, NOW(), NOW())'
        );
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password_hash' => $passwordHash,
            ':role' => $role,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function toggleActive(int $id): void
    {
        $stmt = $this->pdo->prepare('UPDATE users SET is_active = IF(is_active=1, 0, 1), updated_at = NOW() WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function resetPassword(int $id, string $passwordHash): void
    {
        $stmt = $this->pdo->prepare('UPDATE users SET password_hash = :password_hash, updated_at = NOW() WHERE id = :id');
        $stmt->execute([':id' => $id, ':password_hash' => $passwordHash]);
    }
}
