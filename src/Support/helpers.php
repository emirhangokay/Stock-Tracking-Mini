<?php

declare(strict_types=1);

use Src\Services\AuditService;

function request_method(): string
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

function is_post(): bool
{
    return request_method() === 'POST';
}

function input(string $key, mixed $default = null): mixed
{
    return $_POST[$key] ?? $_GET[$key] ?? $default;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function pull_flashes(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function user_id(): ?int
{
    return current_user()['id'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function is_admin(): bool
{
    return (current_user()['role'] ?? '') === 'Admin';
}

function require_auth(): void
{
    if (!is_logged_in()) {
        flash('warning', 'Devam etmek icin giris yapiniz.');
        header('Location: /index.php?route=login');
        exit;
    }
}

function require_admin(): void
{
    require_auth();
    if (!is_admin()) {
        http_response_code(403);
        echo 'Bu alana erisim yetkiniz yok.';
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['_csrf'];
}

function verify_csrf(): void
{
    if (!is_post()) {
        return;
    }

    $token = $_POST['_csrf'] ?? '';
    if (!hash_equals($_SESSION['_csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Gecersiz CSRF token.');
    }
}

function audit(string $action, ?string $entityType = null, ?int $entityId = null, ?string $details = null): void
{
    (new AuditService(db()))->log(user_id(), $action, $entityType, $entityId, $details);
}
