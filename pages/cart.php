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
                                <img src="<?= htmlspecialchars($item['image_link']) ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>">
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