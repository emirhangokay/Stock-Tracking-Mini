<?php

declare(strict_types=1);

namespace Src\Models;

use PDO;

class SaleModel
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function list(): array
    {
        $sql = 'SELECT s.*, u.name AS created_by_name
                FROM sales s
                JOIN users u ON u.id = s.created_by
                ORDER BY s.sale_date DESC, s.id DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(string $customerName, float $totalAmount, int $userId): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO sales (customer_name, sale_date, total_amount, created_by, created_at)
             VALUES (:customer_name, NOW(), :total_amount, :created_by, NOW())'
        );
        $stmt->execute([
            ':customer_name' => $customerName,
            ':total_amount' => $totalAmount,
            ':created_by' => $userId,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function addItem(int $saleId, int $productId, float $qty, float $unitPrice, float $lineTotal): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO sale_items (sale_id, product_id, qty, unit_price, line_total, created_at)
             VALUES (:sale_id, :product_id, :qty, :unit_price, :line_total, NOW())'
        );

        $stmt->execute([
            ':sale_id' => $saleId,
            ':product_id' => $productId,
            ':qty' => $qty,
            ':unit_price' => $unitPrice,
            ':line_total' => $lineTotal,
        ]);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, u.name AS created_by_name
             FROM sales s
             JOIN users u ON u.id = s.created_by
             WHERE s.id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        $sale = $stmt->fetch();
        if (!$sale) {
            return null;
        }

        $itemStmt = $this->pdo->prepare(
            'SELECT si.*, p.name AS product_name, p.sku
             FROM sale_items si
             JOIN products p ON p.id = si.product_id
             WHERE si.sale_id = :sale_id'
        );
        $itemStmt->execute([':sale_id' => $id]);
        $sale['items'] = $itemStmt->fetchAll();

        return $sale;
    }
}
