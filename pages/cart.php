<?php
$cart_error = $_SESSION['cart_error'] ?? null;
$cart_success = $_SESSION['cart_success'] ?? null;
unset($_SESSION['cart_error'], $_SESSION['cart_success']);
?>
<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-cart-shopping"></i> Mon Panier
    </h2>

    <?php if ($cart_error): ?>
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> <?= $cart_error ?>
        </div>
    <?php endif; ?>

    <?php if ($cart_success): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($cart_success) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="auth-container dark-form glass-card form-card text-center cart-empty-container">
            <i class="fa-solid fa-basket-shopping cart-empty-basket"></i>
            <h3>Votre panier est vide.</h3>
            <p class="cart-empty-text">Découvrez notre sélection d'équipements pour commencer vos achats.</p>
            <a href="articles" class="btn-primary">Retour au catalogue</a>
        </div>
    <?php else: ?>
        <form action="cart" method="POST">
            <div class="cart-layout">
                <div class="glass-card cart-table-wrapper">
                    <div class="table-scroll">
                        <table class="table-dark cart-table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th class="cart-qty-column">Quantité</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="cart-item-info">
                                                <div class="cart-item-img-wrapper">
                                                    <?php if (!empty($item['image_link'])): ?>
                                                        <img src="<?= htmlspecialchars($item['image_link']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="cart-item-img">
                                                    <?php else: ?>
                                                        <i class="fa-solid fa-image cart-item-img-placeholder"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <a href="detail&id=<?= $item['article_id'] ?>" class="cart-item-title">
                                                    <?= htmlspecialchars($item['name']) ?>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="cart-item-price">
                                            <?= number_format($item['price'], 2) ?> €
                                        </td>
                                        <td>
                                            <div class="cart-qty-wrapper">
                                                <input type="number" name="quantities[<?= $item['cart_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="cart-qty-input">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="cart?remove=<?= $item['cart_id'] ?>" class="btn-secondary btn-danger btn-small" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir retirer cet article du panier ?');">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="cart-update-wrapper">
                        <button type="submit" name="update_cart" class="btn-secondary">
                            <i class="fa-solid fa-arrows-rotate"></i> Mettre à jour la quantité
                        </button>
                    </div>
                </div>

                <div class="glass-card cart-summary-wrapper">
                    <h3 class="cart-summary-title">Récapitulatif</h3>
                    
                    <div class="cart-summary-row">
                        <span class="cart-summary-label">Total HT</span>
                        <span><?= number_format($totalHT, 2) ?> €</span>
                    </div>
                    
                    <div class="cart-summary-total">
                        <span>Total TTC</span>
                        <span><?= number_format($totalTTC, 2) ?> €</span>
                    </div>
                    
                    <a href="cart_validation" class="btn-primary btn-full-width btn-glow cart-validate-btn">
                        Valider la commande <i class="fa-solid fa-arrow-right cart-validate-icon"></i>
                    </a>
                    
                    <div class="cart-continue">
                        <a href="articles">
                            <i class="fa-solid fa-arrow-left"></i> Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>