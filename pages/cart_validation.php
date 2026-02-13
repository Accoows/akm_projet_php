<?php
$pageTitle = "Validation de la commande";

$cart_items = [
    [
        'id' => 1,
        'name' => 'Casque FAST',
        'price' => 120.00,
        'quantity' => 1,
        'image' => 'assets/images/placeholder.png'
    ],
    [
        'id' => 2,
        'name' => 'Gilet Tactique JPC',
        'price' => 85.50,
        'quantity' => 2,
        'image' => 'assets/images/placeholder.png'
    ]
];

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-truck-fast"></i> Validation de la commande
    </h2>

    <div class="checkout-container">
        <!-- Left: Shipping Form -->
        <div class="checkout-form dark-form">
            <h3><i class="fa-solid fa-location-dot"></i> Adresse de livraison</h3>
            <form action="" method="POST" id="checkout-form">
                <div class="form-group">
                    <label for="fullname">Nom complet</label>
                    <input type="text" id="fullname" name="fullname" placeholder="John Doe" required>
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

                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone" placeholder="06 12 34 56 78" required>
                </div>
            </form>
        </div>

        <!-- Right: Order Summary -->
        <div class="checkout-summary">
            <h3><i class="fa-solid fa-file-invoice-dollar"></i> Récapitulatif</h3>

            <div class="summary-items">
                <?php foreach ($cart_items as $item): ?>
                    <div class="summary-item">
                        <span>
                            <?= htmlspecialchars($item['name']) ?> (x
                            <?= $item['quantity'] ?>)
                        </span>
                        <span>
                            <?= number_format($item['price'] * $item['quantity'], 2) ?> €
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="summary-total">
                <span>Total à payer</span>
                <span>
                    <?= number_format($total, 2) ?> €
                </span>
            </div>

            <button type="submit" form="checkout-form" class="btn-primary btn-full-width">
                <i class="fa-solid fa-lock"></i> Confirmer et Payer
            </button>
            <br>
            <a href="cart" class="btn-secondary btn-full-width">
                Retour au panier
            </a>
        </div>
    </div>
</div>