<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\ProductModel;
use Src\Models\SaleModel;
use Src\Models\StockMovementModel;
use Src\Services\SaleService;

class SaleController extends Controller
{
    public function index(): void
    {
        $sales = (new SaleModel(db()))->list();
        $this->render('sales/index', ['title' => 'Satislar', 'sales' => $sales]);
    }

    public function create(): void
    {
        $products = (new ProductModel(db()))->activeForSelect();
        $this->render('sales/create', ['title' => 'Yeni Satis', 'products' => $products]);
    }

    public function store(): void
    {
        $customerName = trim((string)input('customer_name', ''));
        $productIds = $_POST['product_id'] ?? [];
        $qtys = $_POST['qty'] ?? [];
        $prices = $_POST['unit_price'] ?? [];

        $items = [];
        $count = max(count($productIds), count($qtys), count($prices));
        for ($i = 0; $i < $count; $i++) {
            if (!isset($productIds[$i], $qtys[$i], $prices[$i])) {
                continue;
            }

            if ((int)$productIds[$i] <= 0 || (float)$qtys[$i] <= 0) {
                continue;
            }

            $items[] = [
                'product_id' => (int)$productIds[$i],
                'qty' => (float)$qtys[$i],
                'unit_price' => (float)$prices[$i],
            ];
        }

        $service = new SaleService(db(), new SaleModel(db()), new StockMovementModel(db()));

        try {
            $saleId = $service->createSale($customerName, $items, (int)user_id());
            audit('sale_create', 'sales', $saleId, 'Satis olusturuldu');
            flash('success', 'Satis basariyla kaydedildi.');
            $this->redirect('sales.show&id=' . $saleId);
        } catch (\Throwable $e) {
            flash('danger', 'Satis kaydedilemedi: ' . $e->getMessage());
            $this->redirect('sales.create');
        }
    }

    public function show(): void
    {
        $id = (int)input('id', 0);
        $sale = (new SaleModel(db()))->find($id);

        if (!$sale) {
            flash('danger', 'Satis bulunamadi.');
            $this->redirect('sales');
        }

        $this->render('sales/show', ['title' => 'Satis Detayi', 'sale' => $sale]);
    }
}
