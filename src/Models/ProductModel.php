<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;

class ProductModel
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function allWithRelations(): array
    {
        $sql = 'SELECT p.*, b.name AS brand_name, c.name AS category_name,
                       COALESCE(SUM(CASE WHEN sm.movement_type = "IN" THEN sm.qty ELSE -sm.qty END), 0) AS current_stock
                FROM products p
                JOIN brands b ON b.id = p.brand_id
                JOIN categories c ON c.id = p.category_id
                LEFT JOIN stock_movements sm ON sm.product_id = p.id
                GROUP BY p.id
                ORDER BY p.id DESC';

        return $this->pdo->query($sql)->fetchAll();
    }

    public function activeForSelect(): array
    {
        $sql = 'SELECT p.id, p.name, p.sku,
                       COALESCE(SUM(CASE WHEN sm.movement_type = "IN" THEN sm.qty ELSE -sm.qty END), 0) AS current_stock
                FROM products p
                LEFT JOIN stock_movements sm ON sm.product_id = p.id
                WHERE p.is_active = 1
                GROUP BY p.id
                ORDER BY p.name ASC';

        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(array $payload): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO products (name, sku, brand_id, category_id, unit, critical_stock_level, is_active, created_at, updated_at)
             VALUES (:name, :sku, :brand_id, :category_id, :unit, :critical_stock_level, :is_active, NOW(), NOW())'
        );
        $stmt->execute([
            ':name' => $payload['name'],
            ':sku' => $payload['sku'],
            ':brand_id' => $payload['brand_id'],
            ':category_id' => $payload['category_id'],
            ':unit' => $payload['unit'],
            ':critical_stock_level' => $payload['critical_stock_level'],
            ':is_active' => $payload['is_active'],
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $payload): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE products
             SET name = :name, sku = :sku, brand_id = :brand_id, category_id = :category_id,
                 unit = :unit, critical_stock_level = :critical_stock_level, is_active = :is_active,
                 updated_at = NOW()
             WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $id,
            ':name' => $payload['name'],
            ':sku' => $payload['sku'],
            ':brand_id' => $payload['brand_id'],
            ':category_id' => $payload['category_id'],
            ':unit' => $payload['unit'],
            ':critical_stock_level' => $payload['critical_stock_level'],
            ':is_active' => $payload['is_active'],
        ]);
    }

    public function findWithRelations(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.*, b.name AS brand_name, c.name AS category_name,
                    COALESCE(SUM(CASE WHEN sm.movement_type = "IN" THEN sm.qty ELSE -sm.qty END), 0) AS current_stock
             FROM products p
             JOIN brands b ON b.id = p.brand_id
             JOIN categories c ON c.id = p.category_id
             LEFT JOIN stock_movements sm ON sm.product_id = p.id
             WHERE p.id = :id
             GROUP BY p.id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function toggleActive(int $id): void
    {
        $stmt = $this->pdo->prepare('UPDATE products SET is_active = IF(is_active=1, 0, 1), updated_at = NOW() WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function lastMovements(int $productId, int $limit = 10): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT sm.*, u.name AS user_name
             FROM stock_movements sm
             JOIN users u ON u.id = sm.user_id
             WHERE sm.product_id = :product_id
             ORDER BY sm.movement_date DESC, sm.id DESC
             LIMIT ' . (int)$limit
        );
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll();
    }

    public function lastSales(int $productId, int $limit = 10): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT si.*, s.customer_name, s.sale_date, s.id AS sale_id
             FROM sale_items si
             JOIN sales s ON s.id = si.sale_id
             WHERE si.product_id = :product_id
             ORDER BY s.sale_date DESC, si.id DESC
             LIMIT ' . (int)$limit
        );
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll();
    }
}
