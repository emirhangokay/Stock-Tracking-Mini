<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Models\BrandModel;

class BrandController extends Controller
{
    public function index(): void
    {
        $brands = (new BrandModel(db()))->all();
        $this->render('brands/index', ['title' => 'Markalar', 'brands' => $brands]);
    }

    public function store(): void
    {
        $name = trim((string)input('name', ''));
        if ($name === '') {
            flash('danger', 'Marka adi zorunludur.');
            $this->redirect('brands');
        }

        try {
            $id = (new BrandModel(db()))->create($name);
            audit('brand_create', 'brands', $id, 'Marka eklendi');
            flash('success', 'Marka eklendi.');
        } catch (\Throwable $e) {
            flash('danger', 'Marka kaydi basarisiz: ' . $e->getMessage());
        }

        $this->redirect('brands');
    }

    public function update(): void
    {
        $id = (int)input('id', 0);
        $name = trim((string)input('name', ''));

        if ($id <= 0 || $name === '') {
            flash('danger', 'Gecersiz veri.');
            $this->redirect('brands');
        }

        (new BrandModel(db()))->update($id, $name);
        audit('brand_update', 'brands', $id, 'Marka guncellendi');
        flash('success', 'Marka guncellendi.');
        $this->redirect('brands');
    }

    public function toggleActive(): void
    {
        $id = (int)input('id', 0);
        if ($id <= 0) {
            flash('danger', 'Gecersiz marka.');
            $this->redirect('brands');
        }

        (new BrandModel(db()))->toggleActive($id);
        audit('brand_toggle_active', 'brands', $id, 'Marka aktiflik degisti');
        flash('success', 'Marka durumu degisti.');
        $this->redirect('brands');
    }
}
