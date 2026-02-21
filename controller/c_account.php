<?php
// controller/c_account.php

$userId = $_SESSION['user']['id'];
$user = [];
$invoices = [];

try {
    // 1. Récupérer infos utilisateur à jour
    $stmtUser = $pdo->prepare("SELECT * FROM User WHERE id = ?");
    $stmtUser->execute([$userId]);
    $user = $stmtUser->fetch();

    // Mettre à jour la session si besoin
    if ($user) {
        $_SESSION['user']['balance'] = $user['balance']; // On suppose que la clé existe ou on l'ajoute
    }

    // 2. Récupérer l'historique des commandes
    $stmtInv = $pdo->prepare("SELECT * FROM Invoice WHERE user_id = ? ORDER BY transaction_date DESC");
    $stmtInv->execute([$userId]);
    $invoices = $stmtInv->fetchAll();

} catch (PDOException $e) {
    // Silent error
}
