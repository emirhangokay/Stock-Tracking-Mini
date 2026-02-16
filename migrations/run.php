<?php

declare(strict_types=1);

$baseDir = dirname(__DIR__);
require_once $baseDir . '/src/bootstrap.php';

$pdo = db();
$files = glob(__DIR__ . '/*.sql');
sort($files);

foreach ($files as $file) {
    $baseName = basename($file);

    // Seed dosyalari ayri komutla calistirilir (seed.php).
    if (stripos($baseName, 'seed') !== false) {
        echo "Skipping seed file: {$baseName}" . PHP_EOL;
        continue;
    }

    echo "Running: " . $baseName . PHP_EOL;
    $sql = file_get_contents($file);
    if ($sql === false) {
        throw new RuntimeException("Cannot read $file");
    }
    $pdo->exec($sql);
}

echo "Migrations completed." . PHP_EOL;
