<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;

class StockMovementModel
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function create(array $payload): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO stock_movements (product_id, movement_type, qty, movement_date, user_id, note, reference_sale_id, created_at)
             VALUES (:product_id, :movement_type, :qty, :movement_date, :user_id, :note, :reference_sale_id, NOW())'
        );

        $stmt->execute([
            ':product_id' => $payload['product_id'],
            ':movement_type' => $payload['movement_type'],
            ':qty' => $payload['qty'],
            ':movement_date' => $payload['movement_date'] ?? now(),
            ':user_id' => $payload['user_id'],
            ':note' => $payload['note'] ?? null,
            ':reference_sale_id' => $payload['reference_sale_id'] ?? null,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function list(int $limit = 200): array
    {
        $sql = 'SELECT sm.*, p.name AS product_name, p.sku, u.name AS user_name
                FROM stock_movements sm
                JOIN products p ON p.id = sm.product_id
                JOIN users u ON u.id = sm.user_id
                ORDER BY sm.movement_date DESC, sm.id DESC
                LIMIT ' . (int)$limit;

        return $this->pdo->query($sql)->fetchAll();
    }

    public function currentStock(int $productId): float
    {
        $stmt = $this->pdo->prepare(
            'SELECT COALESCE(SUM(CASE WHEN movement_type = "IN" THEN qty ELSE -qty END), 0) AS stock
             FROM stock_movements
             WHERE product_id = :product_id'
        );
        $stmt->execute([':product_id' => $productId]);
        return (float)($stmt->fetch()['stock'] ?? 0);
    }
}
