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
                            <img src="<?= htmlspecialchars($product['image_link']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>">
                        <?php else: ?>
                            <i class="fa-solid fa-image"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="article-title">
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>
                    <p class="article-category">

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