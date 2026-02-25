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
        <form action="articles" method="GET" class="search-form articles-search-form">
            <!-- Hidden input if the router relies on ?page=articles -->
            <?php if(isset($_GET['page'])): ?>
                <input type="hidden" name="page" value="articles">
            <?php endif; ?>
            <?php if(isset($_GET['q'])): ?>
                <input type="hidden" name="q" value="<?= htmlspecialchars($_GET['q']) ?>">
            <?php endif; ?>

            <div class="custom-dropdown-wrapper" id="sortDropdown">
                <input type="hidden" name="sort" id="sortInput" value="<?= isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'newest' ?>">
                
                <?php 
                $sortLabels = [
                    'newest' => 'Plus récents',
                    'oldest' => 'Plus anciens',
                    'price_asc' => 'Prix croissant',
                    'price_desc' => 'Prix décroissant',
                    'name_asc' => 'Nom (A-Z)',
                    'name_desc' => 'Nom (Z-A)'
                ];
                $currentSort = isset($_GET['sort']) && array_key_exists($_GET['sort'], $sortLabels) ? $_GET['sort'] : 'newest';
                $currentLabel = $sortLabels[$currentSort];
                ?>

                <div class="custom-dropdown-trigger search-input">
                    <i class="fa-solid fa-filter"></i>
                    <span id="sortSelectedText"><?= $currentLabel ?></span>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <div class="custom-dropdown-menu">
                    <?php foreach ($sortLabels as $value => $label): ?>
                        <div class="custom-dropdown-option <?= $currentSort === $value ? 'active' : '' ?>" data-value="<?= $value ?>">
                            <?= $label ?>
                            <?php if ($currentSort === $value): ?>
                                <i class="fa-solid fa-check"></i>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
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