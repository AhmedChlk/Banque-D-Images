<?php

function getUserContacts(PDO $pdo, int $userId): array {
    $sql = "SELECT u.id, u.login
            FROM contacts c
            JOIN users u ON c.contact_user_id = u.id
            WHERE c.user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
