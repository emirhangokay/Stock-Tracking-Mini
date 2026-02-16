<?php

declare(strict_types=1);

use Src\Core\Database;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

spl_autoload_register(function (string $class): void {
    $prefix = 'Src\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $path = BASE_PATH . '/src/' . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

if (!function_exists('load_env')) {
    function load_env(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            $_ENV[$key] = $value;
            putenv($key . '=' . $value);
        }
    }
}

load_env(BASE_PATH . '/.env');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function env(string $key, ?string $default = null): ?string
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

function db(): PDO
{
    return Database::connection();
}

function now(): string
{
    return date('Y-m-d H:i:s');
}
