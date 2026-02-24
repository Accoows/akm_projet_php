<div class="container">
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-tagline">Équipement Tactique Premium</span>
            <h1>L'excellence à votre portée</h1>
            <p>Découvrez notre sélection exclusive 2025. Conçue pour la performance, testée pour le terrain.</p>
        </div>
    </section>

    <div class="search-container">
        <form action="articles" method="GET" class="search-form">
            <!-- Hidden input if the router relies on ?page=articles -->
            <?php if(isset($_GET['page'])): ?>
                <input type="hidden" name="page" value="articles">
            <?php endif; ?>
            <div class="search-input-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" placeholder="Rechercher un équipement, une marque..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" class="search-input">
                <button type="submit" class="btn-primary search-btn">Rechercher</button>
            </div>
        </form>
        <?php if(isset($_GET['q']) && !empty($_GET['q'])): ?>
            <p class="search-results-text">
                <?= count($products) ?> résultat(s) pour "<strong><?= htmlspecialchars($_GET['q']) ?></strong>"
                <a href="articles" class="clear-search"><i class="fa-solid fa-times-circle"></i> Effacer</a>
            </p>
        <?php endif; ?>
    </div>

    <div class="grid-articles">
        <?php if (empty($products)): ?>
            <div class="no-results-card">
                <i class="fa-solid fa-box-open"></i>
                <h3>Aucun équipement trouvé</h3>
                <p>Essayez avec d'autres mots-clés ou <a href="articles">revenez au catalogue</a>.</p>
            </div>
        <?php else: ?>
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
                    </div>
                </a>
                <div class="article-info pt-0">
                    <a href="account&id=<?= $product['author_id'] ?>" class="article-seller text-link d-inline-block">
                        <i class="fa-solid fa-user"></i> <?= htmlspecialchars($product['seller_name'] ?? 'Inconnu') ?>
                    </a>
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
        <?php endif; ?>
    </div>
</div>