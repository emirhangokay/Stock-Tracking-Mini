<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\CategoryModel;

class CategoryController extends Controller
{
    public function index(): void
    {
        $categories = (new CategoryModel(db()))->all();
        $this->render('categories/index', ['title' => 'Kategoriler', 'categories' => $categories]);
    }

    public function store(): void
    {
        $name = trim((string)input('name', ''));
        if ($name === '') {
            flash('danger', 'Kategori adi zorunludur.');
            $this->redirect('categories');
        }

        try {
            $id = (new CategoryModel(db()))->create($name);
            audit('category_create', 'categories', $id, 'Kategori eklendi');
            flash('success', 'Kategori eklendi.');
        } catch (\Throwable $e) {
            flash('danger', 'Kategori kaydi basarisiz: ' . $e->getMessage());
        }

        $this->redirect('categories');
    }

    public function update(): void
    {
        $id = (int)input('id', 0);
        $name = trim((string)input('name', ''));

        if ($id <= 0 || $name === '') {
            flash('danger', 'Gecersiz veri.');
            $this->redirect('categories');
        }

        (new CategoryModel(db()))->update($id, $name);
        audit('category_update', 'categories', $id, 'Kategori guncellendi');
        flash('success', 'Kategori guncellendi.');
        $this->redirect('categories');
    }

    public function toggleActive(): void
    {
        $id = (int)input('id', 0);
        if ($id <= 0) {
            flash('danger', 'Gecersiz kategori.');
            $this->redirect('categories');
        }

        (new CategoryModel(db()))->toggleActive($id);
        audit('category_toggle_active', 'categories', $id, 'Kategori aktiflik degisti');
        flash('success', 'Kategori durumu degisti.');
        $this->redirect('categories');
    }
}
