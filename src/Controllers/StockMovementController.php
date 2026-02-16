<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\ProductModel;
use Src\Models\StockMovementModel;

class StockMovementController extends Controller
{
    public function index(): void
    {
        $movementModel = new StockMovementModel(db());
        $products = (new ProductModel(db()))->activeForSelect();

        $this->render('movements/index', [
            'title' => 'Stok Hareketleri',
            'movements' => $movementModel->list(300),
            'products' => $products,
        ]);
    }

    public function store(): void
    {
        $productId = (int)input('product_id', 0);
        $movementType = (string)input('movement_type', 'IN');
        $qty = (float)input('qty', 0);
        $note = trim((string)input('note', ''));

        if ($productId <= 0 || !in_array($movementType, ['IN', 'OUT'], true) || $qty <= 0) {
            flash('danger', 'Hareket verileri gecersiz.');
            $this->redirect('movements');
        }

        $movementModel = new StockMovementModel(db());
        $current = $movementModel->currentStock($productId);
        if ($movementType === 'OUT' && $current < $qty) {
            flash('danger', 'Yetersiz stok. Mevcut: ' . $current);
            $this->redirect('movements');
        }

        $id = $movementModel->create([
            'product_id' => $productId,
            'movement_type' => $movementType,
            'qty' => $qty,
            'movement_date' => now(),
            'user_id' => user_id(),
            'note' => $note,
        ]);

        audit('stock_movement_create', 'stock_movements', $id, 'Tip: ' . $movementType);
        flash('success', 'Stok hareketi kaydedildi.');
        $this->redirect('movements');
    }
}
