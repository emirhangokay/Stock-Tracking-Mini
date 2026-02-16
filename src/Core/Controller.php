<?php

declare(strict_types=1);

namespace Src\Core;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = BASE_PATH . '/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo 'View bulunamadi: ' . htmlspecialchars($view);
            return;
        }

        include BASE_PATH . '/views/layouts/main.php';
    }

    protected function redirect(string $route): void
    {
        $parts = explode('&', $route);
        $baseRoute = array_shift($parts) ?: '';
        $url = '/index.php?route=' . urlencode($baseRoute);

        if (!empty($parts)) {
            $url .= '&' . implode('&', $parts);
        }

        header('Location: ' . $url);
        exit;
    }

    protected function back(string $defaultRoute = 'dashboard'): void
    {
        $route = $_SERVER['HTTP_REFERER'] ?? '/index.php?route=' . $defaultRoute;
        header('Location: ' . $route);
        exit;
    }
}
