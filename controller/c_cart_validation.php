<?php
// controller/c_cart_validation.php

$userId = $_SESSION['user']['id'];
$error = null;
$success = null;

// 1. Récupérer le panier
try {
    $stmt = $pdo->prepare("
        SELECT a.id, a.price, a.name 
        FROM Cart c 
        JOIN Article a ON c.article_id = a.id 
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();
} catch (PDOException $e) {
    $cartItems = [];
}

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'];
}

// 2. Traitement du formulaire
if (isPost()) {
    $address = sanitize($_POST['address']);
    $city = sanitize($_POST['city']);
    $zip = sanitize($_POST['zip']);

    if (empty($cartItems)) {
        $error = "Votre panier est vide.";
    } elseif ($total > $_SESSION['user']['balance']) { // (Si on avait mis à jour la session avec le solde réel)
        // Note: Idéalement il faut rafraîchir le solde depuis la DB avant
        $stmtBalance = $pdo->prepare("SELECT balance FROM User WHERE id = ?");
        $stmtBalance->execute([$userId]);
        $currentBalance = $stmtBalance->fetchColumn();

        if ($total > $currentBalance) {
            $error = "Solde insuffisant. Votre solde actuel est de " . number_format($currentBalance, 2) . " €.";
        }
    }

    // Si pas d'erreur de solde (ou vérification faite ci-dessus), on procède
    if (!$error && !empty($address) && !empty($city) && !empty($zip)) {
        try {
            $pdo->beginTransaction();

            // 1. Débiter l'utilisateur
            $stmtUpdateUser = $pdo->prepare("UPDATE User SET balance = balance - ? WHERE id = ?");
            $stmtUpdateUser->execute([$total, $userId]);

            // 2. Créer la facture
            $fullAddress = $address . ', ' . $zip . ' ' . $city;
            $stmtInvoice = $pdo->prepare("INSERT INTO Invoice (user_id, amount, billing_address, billing_city, billing_zip, transaction_date) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmtInvoice->execute([$userId, $total, $address, $city, $zip]);

            // 3. Mettre à jour les stocks
            $stmtStock = $pdo->prepare("UPDATE Stock SET quantity = quantity - 1 WHERE article_id = ? AND quantity > 0");
            foreach ($cartItems as $item) {
                $stmtStock->execute([$item['id']]);
            }

            // 4. Vider le panier
            $stmtClear = $pdo->prepare("DELETE FROM Cart WHERE user_id = ?");
            $stmtClear->execute([$userId]);

            $pdo->commit();
            $success = "Commande validée avec succès !";
            // Mise à jour session solde pour affichage immédiat
            // (Simplification, idéalement re-fetch user)

        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erreur lors de la validation : " . $e->getMessage();
        }
    } elseif (!$error) {
        $error = "Veuillez remplir l'adresse de livraison.";
    }
}
