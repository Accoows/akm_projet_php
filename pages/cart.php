<?php
// pages/cart.php
require_once 'config/database.php';

if (!isset($_SESSION['user'])) {
    echo "<script>window.location.replace('login');</script>";
    exit();
}

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
                echo "<script>window.location.replace('cart');</script>";
                exit();
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
?>

<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-cart-shopping"></i> Mon Panier
    </h2>

    <?php if (empty($cartItems)): ?>
        <div class="cart-empty">
            <p>Votre panier est vide.</p>
            <a href="articles" class="btn-primary">Retour au catalogue</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <?php if (!empty($item['image_link'])): ?>
                                <img src="<?= htmlspecialchars($item['image_link']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <?php else: ?>
                                <i class="fa-solid fa-image"></i>
                            <?php endif; ?>
                        </div>
                        <div class="item-details">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <span class="item-price"><?= number_format($item['price'], 2) ?> €</span>
                        </div>
                        <div class="item-actions">
                            <a href="cart?remove=<?= $item['cart_id'] ?>" class="btn-remove">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h3>Récapitulatif</h3>
                <div class="summary-row total">
                    <span>Total</span>
                    <span><?= number_format($total, 2) ?> €</span>
                </div>
                <a href="cart_validation" class="btn-primary btn-full-width">
                    Valider la commande <i class="fa-solid fa-check"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>