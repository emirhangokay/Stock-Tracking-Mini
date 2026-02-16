<?php

declare(strict_types=1);

namespace Src\Services;

use PDO;

class DashboardService
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function metrics(): array
    {
        $totalProducts = (int)$this->pdo->query('SELECT COUNT(*) AS c FROM products')->fetch()['c'];

        $criticalSql = 'SELECT COUNT(*) AS c
                        FROM (
                          SELECT p.id,
                                 COALESCE(SUM(CASE WHEN sm.movement_type = "IN" THEN sm.qty ELSE -sm.qty END), 0) AS stock,
                                 p.critical_stock_level
                          FROM products p
                          LEFT JOIN stock_movements sm ON sm.product_id = p.id
                          WHERE p.is_active = 1
                          GROUP BY p.id
                        ) t
                        WHERE t.stock <= t.critical_stock_level';
        $criticalCount = (int)$this->pdo->query($criticalSql)->fetch()['c'];

        $todaySalesCount = (int)$this->pdo->query('SELECT COUNT(*) AS c FROM sales WHERE DATE(sale_date) = CURDATE()')->fetch()['c'];
        $todayRevenue = (float)$this->pdo->query('SELECT COALESCE(SUM(total_amount),0) AS t FROM sales WHERE DATE(sale_date) = CURDATE()')->fetch()['t'];

        return [
            'total_products' => $totalProducts,
            'critical_count' => $criticalCount,
            'today_sales_count' => $todaySalesCount,
            'today_revenue' => $todayRevenue,
        ];
    }

    public function criticalStocks(): array
    {
        $sql = 'SELECT p.id, p.name, p.sku, p.critical_stock_level,
                       COALESCE(SUM(CASE WHEN sm.movement_type = "IN" THEN sm.qty ELSE -sm.qty END), 0) AS current_stock
                FROM products p
                LEFT JOIN stock_movements sm ON sm.product_id = p.id
                WHERE p.is_active = 1
                GROUP BY p.id
                HAVING current_stock <= p.critical_stock_level
                ORDER BY current_stock ASC';

        return $this->pdo->query($sql)->fetchAll();
    }
}
