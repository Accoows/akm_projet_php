<div class="container">
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-tagline">Équipement Tactique Premium</span>
            <h1>L'excellence à votre portée</h1>
            <p>Découvrez notre sélection exclusive 2025. Conçue pour la performance, testée pour le terrain.</p>
        </div>
    </section>

    <div class="grid-articles">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <a href="detail?id=<?= $product['id'] ?>" class="card-link">
                    <div class="article-image">
                        <?php if (!empty($product['image_link'])): ?>
                            <img src="<?= htmlspecialchars($product['image_link']) ?>"
                                 alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="image-placeholder"><i class="fa-solid fa-image"></i></div>
                        <?php endif; ?>
                        
                        <span class="card-badge">Équipement</span>
                    </div>

                    <div class="article-info">
                        <h3 class="article-title">
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>
                        <div class="article-seller">
                            <i class="fa-solid fa-user"></i> <?= htmlspecialchars($product['seller_name'] ?? 'Inconnu') ?>
                        </div>
                        <p class="article-description">
                            <?= htmlspecialchars(substr($product['description'] ?? '', 0, 60)) ?>...
                        </p>
                    </div>
                </a>

                <div class="article-actions">
                    <div class="article-price">
                        <?= number_format($product['price'], 2) ?> €
                    </div>
                    
                    <form action="cart" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" name="add_to_cart" class="btn-cart-icon" title="Ajouter au panier">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>