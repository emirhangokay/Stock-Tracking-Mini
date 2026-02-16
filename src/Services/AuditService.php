<?php

declare(strict_types=1);

namespace Src\Services;

use PDO;

class AuditService
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function log(?int $userId, string $action, ?string $entityType = null, ?int $entityId = null, ?string $details = null): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO audit_logs (user_id, action, entity_type, entity_id, details, created_at)
             VALUES (:user_id, :action, :entity_type, :entity_id, :details, NOW())'
        );

        $stmt->execute([
            ':user_id' => $userId,
            ':action' => $action,
            ':entity_type' => $entityType,
            ':entity_id' => $entityId,
            ':details' => $details,
        ]);
    }
}
