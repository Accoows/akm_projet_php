<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-truck-fast"></i> Validation de la commande
    </h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            <br><br>
            <a href="account" class="btn-primary">Voir mon compte</a>
        </div>
    <?php else: ?>

        <div class="checkout-container">
            <!-- Left: Shipping Form -->
            <div class="checkout-form dark-form">
                <h3><i class="fa-solid fa-location-dot"></i> Adresse de livraison</h3>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="cart_validation" method="POST" id="checkout-form">
                    <div class="form-group">
                        <label for="fullname">Nom complet</label>
                        <input type="text" id="fullname" name="fullname" placeholder="John Doe" required
                            value="<?= htmlspecialchars($_SESSION['user']['username']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" id="address" name="address" placeholder="123 Rue de la Base" required>
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" id="city" name="city" placeholder="Paris" required>
                    </div>

                    <div class="form-group">
                        <label for="zip">Code Postal</label>
                        <input type="text" id="zip" name="zip" placeholder="75000" required>
                    </div>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="checkout-summary">
                <h3><i class="fa-solid fa-file-invoice-dollar"></i> Récapitulatif</h3>

                <div class="summary-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="summary-item">
                            <span><?= htmlspecialchars($item['name']) ?></span>
                            <span><?= number_format($item['price'], 2) ?> €</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-total">
                    <span>Total à payer</span>
                    <span><?= number_format($total, 2) ?> €</span>
                </div>

                <?php if (!empty($cartItems)): ?>
                    <button type="submit" form="checkout-form" class="btn-primary btn-full-width">
                        <i class="fa-solid fa-lock"></i> Confirmer et Payer
                    </button>
                <?php endif; ?>
                <br>
                <a href="cart" class="btn-secondary btn-full-width">
                    Retour au panier
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>