<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/src/bootstrap.php';
require_once BASE_PATH . '/src/Support/helpers.php';

use Src\Controllers\AuthController;
use Src\Controllers\BrandController;
use Src\Controllers\CategoryController;
use Src\Controllers\DashboardController;
use Src\Controllers\ProductController;
use Src\Controllers\ReportController;
use Src\Controllers\SaleController;
use Src\Controllers\StockMovementController;
use Src\Controllers\UserController;
use Src\Core\Router;

$router = new Router();

$router->add('login', [AuthController::class, 'showLogin']);
$router->add('login.post', [AuthController::class, 'login']);
$router->add('logout', [AuthController::class, 'logout'], 'require_auth');

$router->add('', [DashboardController::class, 'index'], 'require_auth');
$router->add('dashboard', [DashboardController::class, 'index'], 'require_auth');

$router->add('users', [UserController::class, 'index'], 'require_admin');
$router->add('users.create', [UserController::class, 'create'], 'require_admin');
$router->add('users.store', [UserController::class, 'store'], 'require_admin');
$router->add('users.toggle', [UserController::class, 'toggleActive'], 'require_admin');
$router->add('users.reset-password', [UserController::class, 'resetPassword'], 'require_admin');

$router->add('brands', [BrandController::class, 'index'], 'require_auth');
$router->add('brands.store', [BrandController::class, 'store'], 'require_auth');
$router->add('brands.update', [BrandController::class, 'update'], 'require_auth');
$router->add('brands.toggle', [BrandController::class, 'toggleActive'], 'require_auth');

$router->add('categories', [CategoryController::class, 'index'], 'require_auth');
$router->add('categories.store', [CategoryController::class, 'store'], 'require_auth');
$router->add('categories.update', [CategoryController::class, 'update'], 'require_auth');
$router->add('categories.toggle', [CategoryController::class, 'toggleActive'], 'require_auth');

$router->add('products', [ProductController::class, 'index'], 'require_auth');
$router->add('products.create', [ProductController::class, 'create'], 'require_auth');
$router->add('products.store', [ProductController::class, 'store'], 'require_auth');
$router->add('products.edit', [ProductController::class, 'edit'], 'require_auth');
$router->add('products.update', [ProductController::class, 'update'], 'require_auth');
$router->add('products.show', [ProductController::class, 'show'], 'require_auth');
$router->add('products.toggle', [ProductController::class, 'toggleActive'], 'require_auth');

$router->add('movements', [StockMovementController::class, 'index'], 'require_auth');
$router->add('movements.store', [StockMovementController::class, 'store'], 'require_auth');

$router->add('sales', [SaleController::class, 'index'], 'require_auth');
$router->add('sales.create', [SaleController::class, 'create'], 'require_auth');
$router->add('sales.store', [SaleController::class, 'store'], 'require_auth');
$router->add('sales.show', [SaleController::class, 'show'], 'require_auth');

$router->add('reports', [ReportController::class, 'index'], 'require_auth');

$route = input('route', 'dashboard');
if (!is_logged_in() && !in_array($route, ['login', 'login.post'], true)) {
    header('Location: /index.php?route=login');
    exit;
}

try {
    verify_csrf();
    $router->dispatch((string)$route);
} catch (Throwable $e) {
    if (env('APP_DEBUG', 'false') === 'true') {
        http_response_code(500);
        echo '<pre>' . e($e->getMessage() . "\n" . $e->getTraceAsString()) . '</pre>';
    } else {
        http_response_code(500);
        echo 'Beklenmeyen bir hata olustu.';
    }
}
