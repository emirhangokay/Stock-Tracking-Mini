<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\BrandModel;
use Src\Models\CategoryModel;
use Src\Models\ProductModel;

class ProductController extends Controller
{
    public function index(): void
    {
        $products = (new ProductModel(db()))->allWithRelations();
        $this->render('products/index', ['title' => 'Urunler', 'products' => $products]);
    }

    public function create(): void
    {
        $brandModel = new BrandModel(db());
        $categoryModel = new CategoryModel(db());

        $this->render('products/create', [
            'title' => 'Urun Ekle',
            'brands' => $brandModel->active(),
            'categories' => $categoryModel->active(),
        ]);
    }

    public function store(): void
    {
        $payload = $this->validatedPayload();
        if ($payload === null) {
            $this->redirect('products.create');
        }

        try {
            $id = (new ProductModel(db()))->create($payload);
            audit('product_create', 'products', $id, 'Urun eklendi');
            flash('success', 'Urun eklendi.');
            $this->redirect('products');
        } catch (\Throwable $e) {
            flash('danger', 'Urun eklenemedi: ' . $e->getMessage());
            $this->redirect('products.create');
        }
    }

    public function edit(): void
    {
        $id = (int)input('id', 0);
        $productModel = new ProductModel(db());
        $product = $productModel->find($id);
        if (!$product) {
            flash('danger', 'Urun bulunamadi.');
            $this->redirect('products');
        }

        $this->render('products/edit', [
            'title' => 'Urun Duzenle',
            'product' => $product,
            'brands' => (new BrandModel(db()))->active(),
            'categories' => (new CategoryModel(db()))->active(),
        ]);
    }

    public function update(): void
    {
        $id = (int)input('id', 0);
        if ($id <= 0) {
            flash('danger', 'Gecersiz urun.');
            $this->redirect('products');
        }

        $payload = $this->validatedPayload();
        if ($payload === null) {
            $this->redirect('products.edit&id=' . $id);
        }

        try {
            (new ProductModel(db()))->update($id, $payload);
            audit('product_update', 'products', $id, 'Urun guncellendi');
            flash('success', 'Urun guncellendi.');
            $this->redirect('products');
        } catch (\Throwable $e) {
            flash('danger', 'Urun guncellenemedi: ' . $e->getMessage());
            $this->redirect('products.edit&id=' . $id);
        }
    }

    public function show(): void
    {
        $id = (int)input('id', 0);
        $productModel = new ProductModel(db());
        $product = $productModel->findWithRelations($id);

        if (!$product) {
            flash('danger', 'Urun bulunamadi.');
            $this->redirect('products');
        }

        $this->render('products/show', [
            'title' => 'Urun Detayi',
            'product' => $product,
            'movements' => $productModel->lastMovements($id),
            'sales' => $productModel->lastSales($id),
        ]);
    }

    public function toggleActive(): void
    {
        $id = (int)input('id', 0);
        if ($id <= 0) {
            flash('danger', 'Gecersiz urun.');
            $this->redirect('products');
        }

        (new ProductModel(db()))->toggleActive($id);
        audit('product_toggle_active', 'products', $id, 'Urun aktiflik degisti');
        flash('success', 'Urun durumu degisti.');
        $this->redirect('products');
    }

    private function validatedPayload(): ?array
    {
        $name = trim((string)input('name', ''));
        $sku = trim((string)input('sku', ''));
        $brandId = (int)input('brand_id', 0);
        $categoryId = (int)input('category_id', 0);
        $unit = trim((string)input('unit', 'adet')) ?: 'adet';
        $critical = (float)input('critical_stock_level', 0);
        $isActive = input('is_active', '1') === '1' ? 1 : 0;

        if ($name === '' || $sku === '' || $brandId <= 0 || $categoryId <= 0 || $critical < 0) {
            flash('danger', 'Urun bilgileri gecersiz.');
            return null;
        }

        return [
            'name' => $name,
            'sku' => $sku,
            'brand_id' => $brandId,
            'category_id' => $categoryId,
            'unit' => $unit,
            'critical_stock_level' => $critical,
            'is_active' => $isActive,
        ];
    }
}
