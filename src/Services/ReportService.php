<?php

declare(strict_types=1);

namespace Src\Services;

use PDO;

class ReportService
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function dailyRevenue(string $startDate, string $endDate): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT DATE(sale_date) AS day, COUNT(*) AS sales_count, COALESCE(SUM(total_amount), 0) AS revenue
             FROM sales
             WHERE DATE(sale_date) BETWEEN :start_date AND :end_date
             GROUP BY DATE(sale_date)
             ORDER BY day ASC'
        );

        $stmt->execute([
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ]);

        return $stmt->fetchAll();
    }

    public function topProducts(string $startDate, string $endDate, int $limit = 10): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.name, p.sku, SUM(si.qty) AS total_qty
             FROM sale_items si
             JOIN sales s ON s.id = si.sale_id
             JOIN products p ON p.id = si.product_id
             WHERE DATE(s.sale_date) BETWEEN :start_date AND :end_date
             GROUP BY si.product_id
             ORDER BY total_qty DESC
             LIMIT ' . (int)$limit
        );

        $stmt->execute([
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ]);

        return $stmt->fetchAll();
    }
}
