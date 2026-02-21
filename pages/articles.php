<?php
// pages/articles.php
$pageTitle = "Catalogue - Équipement Tactique";

require_once 'config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM article");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
?>

<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-layer-group"></i> Catalogue Complet
    </h2>

    <div class="grid-articles">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="article-content">
                    <div class="article-image">
                        <?php if (!empty($product['image_link'])): ?>
                            <img src="<?= htmlspecialchars($product['image_link']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width:100%; height:auto;">
                        <?php else: ?>
                            <i class="fa-solid fa-image"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="article-title">
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>
                    <p class="article-category">
                        <!-- Category logic to be implemented or removed if not in DB -->
                        <!-- Assuming description for now or just generic -->
                         <?= htmlspecialchars(substr($product['description'] ?? '', 0, 50)) ?>...
                    </p>
                    <div class="article-price">
                        <?= number_format($product['price'], 2) ?> €
                    </div>
                    <button class="btn-primary btn-full-width">
                        <i class="fa-solid fa-cart-plus"></i> Ajouter
                    </button>
                    <a href="detail?id=<?= $product['id'] ?>" class="btn-secondary btn-full-width btn-details">
                        Voir détails
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>