<div class="container">
    <?php if ($product): ?>
        <div class="product-detail-container">
            <div class="detail-image">
                <?php if (!empty($product['image_link'])): ?>
                    <img src="<?= htmlspecialchars($product['image_link']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php else: ?>
                    <i class="fa-solid fa-image"></i>
                <?php endif; ?>
            </div>
            <div class="detail-info">
                <h2 class="detail-title">
                    <?= htmlspecialchars($product['name']) ?>
                </h2>

                <div class="detail-price">
                    <?= number_format($product['price'], 2) ?> €
                </div>

                <p class="detail-description">
                    <?= nl2br(htmlspecialchars($product['description'] ?? '')) ?>
                </p>

                <div class="detail-actions">
                    <!-- Form to add to cart (logic to be implemented later or via link) -->
                    <form action="cart" method="POST" class="form-inline detail-action-form">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn-primary" name="add_to_cart">
                            <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                        </button>
                    </form>

                    <a href="articles" class="btn-secondary detail-action-link">
                        <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
                    </a>
                </div>
                
                <?php
                $isOwner = isset($_SESSION['user']) && $_SESSION['user']['id'] == $product['author_id'];
                $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
                ?>
                <?php if ($isOwner || $isAdmin): ?>
                    <div class="detail-management-section">
                        <h4 class="detail-management-title"><i class="fa-solid fa-gear"></i> Gestion de l'article</h4>
                        <div class="detail-management-actions">
                            <a href="edit_article&id=<?= $product['id'] ?>" class="btn-secondary btn-small">
                                <i class="fa-solid fa-pen"></i> Modifier
                            </a>
                            <a href="delete_article&id=<?= $product['id'] ?>" class="btn-secondary btn-small btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.');">
                                <i class="fa-solid fa-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
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