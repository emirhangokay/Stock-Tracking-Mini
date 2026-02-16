<?php

declare(strict_types=1);

namespace Src\Services;

use PDO;
use RuntimeException;
use Src\Models\SaleModel;
use Src\Models\StockMovementModel;

class SaleService
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly SaleModel $sales,
        private readonly StockMovementModel $movements
    ) {
    }

    public function createSale(string $customerName, array $items, int $userId): int
    {
        if ($customerName === '') {
            throw new RuntimeException('Musteri adi zorunludur.');
        }

        if (count($items) === 0) {
            throw new RuntimeException('En az bir urun satiri ekleyiniz.');
        }

        $this->pdo->beginTransaction();

        try {
            $normalized = [];
            $total = 0.0;

            foreach ($items as $item) {
                $productId = (int)($item['product_id'] ?? 0);
                $qty = (float)($item['qty'] ?? 0);
                $unitPrice = (float)($item['unit_price'] ?? 0);

                if ($productId <= 0 || $qty <= 0 || $unitPrice < 0) {
                    throw new RuntimeException('Satis satirlari gecersiz.');
                }

                $currentStock = $this->movements->currentStock($productId);
                if ($currentStock < $qty) {
                    throw new RuntimeException("Yetersiz stok. Urun ID: {$productId}, mevcut: {$currentStock}, istenen: {$qty}");
                }

                $lineTotal = round($qty * $unitPrice, 2);
                $total += $lineTotal;

                $normalized[] = [
                    'product_id' => $productId,
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ];
            }

            $saleId = $this->sales->create($customerName, round($total, 2), $userId);

            foreach ($normalized as $line) {
                $this->sales->addItem($saleId, $line['product_id'], $line['qty'], $line['unit_price'], $line['line_total']);
                $this->movements->create([
                    'product_id' => $line['product_id'],
                    'movement_type' => 'OUT',
                    'qty' => $line['qty'],
                    'movement_date' => now(),
                    'user_id' => $userId,
                    'note' => 'Satis hareketi',
                    'reference_sale_id' => $saleId,
                ]);
            }

            $this->pdo->commit();
            return $saleId;
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }
}
