<?php
// pages/detail.php

require_once 'config/database.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = null;

if ($product_id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM article WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
    } catch (PDOException $e) {
        $product = null;
    }
}

$pageTitle = $product ? $product['name'] : "Produit introuvable";
?>

<div class="container">
    <?php if ($product): ?>
        <div class="product-detail-container">
            <div class="detail-image">
                <?php if (!empty($product['image_link'])): ?>
                    <img src="<?= htmlspecialchars($product['image_link']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width:100%; height:auto;">
                <?php else: ?>
                    <i class="fa-solid fa-image"></i>
                <?php endif; ?>
            </div>
            <div class="detail-info">
                <h2 class="detail-title">
                    <?= htmlspecialchars($product['name']) ?>
                </h2>
                <!-- Category removed as it's not in DB schema -->
                
                <div class="detail-price">
                    <?= number_format($product['price'], 2) ?> €
                </div>

                <p class="detail-description">
                    <?= nl2br(htmlspecialchars($product['description'] ?? '')) ?>
                </p>

                <div class="detail-actions">
                     <!-- Form to add to cart (logic to be implemented later or via link) -->
                     <form action="cart" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn-primary" name="add_to_cart">
                            <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                        </button>
                    </form>
                    
                    <a href="articles" class="btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="error-page">
            <div class="error-card">
                <h1><i class="fa-solid fa-magnifying-glass-minus"></i> Produit Introuvable</h1>
                <p>L'article que vous cherchez n'existe pas ou a été retiré du catalogue.</p>
                <a href="articles" class="btn-primary">
                    Retour au catalogue
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>