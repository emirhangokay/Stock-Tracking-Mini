<?php

declare(strict_types=1);

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\ReportService;

class ReportController extends Controller
{
    public function index(): void
    {
        $start = (string)input('start_date', date('Y-m-01'));
        $end = (string)input('end_date', date('Y-m-d'));

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $start)) {
            $start = date('Y-m-01');
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $end)) {
            $end = date('Y-m-d');
        }

        $service = new ReportService(db());

        $this->render('reports/index', [
            'title' => 'Raporlar',
            'start' => $start,
            'end' => $end,
            'dailyRevenue' => $service->dailyRevenue($start, $end),
            'topProducts' => $service->topProducts($start, $end),
        ]);
    }
}
