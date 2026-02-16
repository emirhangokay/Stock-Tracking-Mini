<?php

declare(strict_types=1);

$baseDir = dirname(__DIR__);
require_once $baseDir . '/src/bootstrap.php';

$pdo = db();
$defaultPassword = env('DEFAULT_RESET_PASSWORD', '123456');

$userStmt = $pdo->prepare(
    'INSERT INTO users (name, email, password_hash, role, is_active, created_at, updated_at)
     VALUES (:name, :email, :password_hash, :role, 1, NOW(), NOW())
     ON DUPLICATE KEY UPDATE
        name = VALUES(name),
        password_hash = VALUES(password_hash),
        role = VALUES(role),
        is_active = 1,
        updated_at = NOW()'
);

$userStmt->execute([
    ':name' => 'Admin Kullanici',
    ':email' => 'admin@example.com',
    ':password_hash' => password_hash($defaultPassword, PASSWORD_DEFAULT),
    ':role' => 'Admin',
]);

$userStmt->execute([
    ':name' => 'Demo Personel',
    ':email' => 'personel@example.com',
    ':password_hash' => password_hash($defaultPassword, PASSWORD_DEFAULT),
    ':role' => 'Personel',
]);

$sql = file_get_contents(__DIR__ . '/002_seed.sql');

if ($sql === false) {
    throw new RuntimeException('Seed dosyasi okunamadi.');
}

$pdo->exec($sql);
echo "Seed tamamlandi." . PHP_EOL;
