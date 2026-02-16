<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\DashboardService;

class DashboardController extends Controller
{
    public function index(): void
    {
        $service = new DashboardService(db());
        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'metrics' => $service->metrics(),
            'criticalProducts' => $service->criticalStocks(),
        ]);
    }
}
