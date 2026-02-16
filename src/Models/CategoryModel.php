<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;

class CategoryModel
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function all(): array
    {
        return $this->pdo->query('SELECT * FROM categories ORDER BY name ASC')->fetchAll();
    }

    public function active(): array
    {
        return $this->pdo->query('SELECT * FROM categories WHERE is_active = 1 ORDER BY name ASC')->fetchAll();
    }

    public function create(string $name): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO categories (name, is_active, created_at, updated_at) VALUES (:name, 1, NOW(), NOW())');
        $stmt->execute([':name' => $name]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, string $name): void
    {
        $stmt = $this->pdo->prepare('UPDATE categories SET name = :name, updated_at = NOW() WHERE id = :id');
        $stmt->execute([':id' => $id, ':name' => $name]);
    }

    public function toggleActive(int $id): void
    {
        $stmt = $this->pdo->prepare('UPDATE categories SET is_active = IF(is_active=1, 0, 1), updated_at = NOW() WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
