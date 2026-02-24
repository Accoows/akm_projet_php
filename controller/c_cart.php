<?php
// controller/c_cart.php

$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $articleId = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($articleId > 0) {
        try {
            $stmt = $pdo->prepare("SELECT s.quantity FROM Article a JOIN Stock s ON a.id = s.article_id WHERE a.id = ?");
            $stmt->execute([$articleId]);
            $stockQty = $stmt->fetchColumn();

            if ($stockQty > 0) {
                $stmtCheckCart = $pdo->prepare("SELECT id, quantity FROM Cart WHERE user_id = ? AND article_id = ?");
                $stmtCheckCart->execute([$userId, $articleId]);
                $cartRow = $stmtCheckCart->fetch();
                
                if ($cartRow) {
                    $newQty = $cartRow['quantity'] + 1;
                    if ($newQty <= $stockQty) {
                        $stmtUpdate = $pdo->prepare("UPDATE Cart SET quantity = ? WHERE id = ?");
                        $stmtUpdate->execute([$newQty, $cartRow['id']]);
                        $_SESSION['cart_success'] = "Quantité mise à jour dans le panier.";
                        redirect('cart');
                    } else {
                        $_SESSION['cart_error'] = "Impossible d'ajouter ! Stock maximum disponible : " . $stockQty;
                        redirect('cart');
                    }
                } else {
                    $stmtInsert = $pdo->prepare("INSERT INTO Cart (user_id, article_id, quantity) VALUES (?, ?, 1)");
                    $stmtInsert->execute([$userId, $articleId]);
                    $_SESSION['cart_success'] = "Article ajouté au panier.";
                    redirect('cart');
                }
            } else {
                $_SESSION['cart_error'] = "Stock épuisé pour cet article !";
                redirect('cart');
            }
        } catch (PDOException $e) {
            // Log error
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        $alertMessage = "";
        foreach ($_POST['quantities'] as $cartId => $qty) {
            $qty = (int)$qty;
            if ($qty > 0) {
                try {
                    $stmtCheckStock = $pdo->prepare("SELECT s.quantity, a.name FROM Cart c JOIN Stock s ON c.article_id = s.article_id JOIN Article a ON c.article_id = a.id WHERE c.id = ?");
                    $stmtCheckStock->execute([$cartId]);
                    $stockData = $stmtCheckStock->fetch();
                    $stockQty = $stockData['quantity'];
                    $articleName = $stockData['name'];
                    
                    if ($qty > $stockQty) {
                        $qty = $stockQty;
                        $alertMessage .= "Stock insuffisant pour " . htmlspecialchars($articleName) . ". Quantité ajustée à " . $stockQty . ".\n";
                    }
                    if ($qty > 0) {
                        $stmtUpdate = $pdo->prepare("UPDATE Cart SET quantity = ? WHERE id = ? AND user_id = ?");
                        $stmtUpdate->execute([$qty, $cartId, $userId]);
                    }
                } catch (PDOException $e) { }
            } else {
                try {
                    $stmtDel = $pdo->prepare("DELETE FROM Cart WHERE id = ? AND user_id = ?");
                    $stmtDel->execute([$cartId, $userId]);
                } catch (PDOException $e) { }
            }
        }
        
        if (!empty($alertMessage)) {
            $_SESSION['cart_error'] = nl2br(trim($alertMessage));
        } else {
            $_SESSION['cart_success'] = "Quantités mises à jour avec succès.";
        }
        redirect('cart');
    }
}

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

$cartItems = [];
$total = 0;

try {
    $stmt = $pdo->prepare("
        SELECT c.id as cart_id, c.quantity, a.id as article_id, a.name, a.price, a.image_link
        FROM Cart c
        JOIN Article a ON c.article_id = a.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();

    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }
} catch (PDOException $e) {
    $cartItems = [];
}
