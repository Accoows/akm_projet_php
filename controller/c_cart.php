<?php
// controller/c_cart.php

$userId = $_SESSION['user']['id'];

// 1. Gestion de l'ajout au panier (Merged from cart_add.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $articleId = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($articleId > 0) {
        try {
            // Vérifier stock
            $stmt = $pdo->prepare("SELECT s.quantity FROM Article a JOIN Stock s ON a.id = s.article_id WHERE a.id = ?");
            $stmt->execute([$articleId]);
            $quantity = $stmt->fetchColumn();

            if ($quantity > 0) {
                $stmtInsert = $pdo->prepare("INSERT INTO Cart (user_id, article_id) VALUES (?, ?)");
                $stmtInsert->execute([$userId, $articleId]);
                // Refresh pour éviter le resubmit
                redirect('cart');
            } else {
                echo "<script>alert('Stock épuisé !');</script>";
            }
        } catch (PDOException $e) {
            // Log error
        }
    }
}

// 2. Gestion de la suppression d'un item
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $cartId = (int) $_GET['remove'];
    try {
        $stmtDel = $pdo->prepare("DELETE FROM Cart WHERE id = ? AND user_id = ?");
        $stmtDel->execute([$cartId, $userId]);
        redirect('cart');
    } catch (PDOException $e) {
        // Silent error
    }
}

// 3. Affichage du panier
$cartItems = [];
$total = 0;

try {
    $stmt = $pdo->prepare("
        SELECT c.id as cart_id, a.id as article_id, a.name, a.price, a.image_link
        FROM Cart c
        JOIN Article a ON c.article_id = a.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();

    foreach ($cartItems as $item) {
        $total += $item['price'];
    }
} catch (PDOException $e) {
    $cartItems = [];
}
