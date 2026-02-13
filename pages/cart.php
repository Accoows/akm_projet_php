<?php
// pages/cart.php
// Mock data for display purposes
// $cart_items = [];

$cart_items = [
    [
        'id' => 1,
        'name' => 'Casque FAST',
        'price' => 120.00,
        'quantity' => 1,
        'image' => 'assets/images/placeholder.png' // You might need a placeholder image
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
        <i class="fa-solid fa-cart-shopping"></i> Votre Panier
    </h2>

    <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <i class="fa-solid fa-cart-arrow-down"></i>
            <h3>Votre panier est vide</h3>
            <p>Préparez votre équipement avant de partir en mission.</p>
            <a href="home" class="btn-primary">
                Retour au catalogue
            </a>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td>
                                <div class="cart-item-container">
                                    <div class="cart-item-image">
                                        <i class="fa-solid fa-image cart-item-placeholder-icon"></i>
                                    </div>
                                    <span class="cart-item-name"><?= htmlspecialchars($item['name']) ?></span>
                                </div>
                            </td>
                            <td><?= number_format($item['price'], 2) ?> €</td>
                            <td>
                                <input type="number" value="<?= $item['quantity'] ?>" min="1" class="cart-input-quantity">
                            </td>
                            <td class="cart-row-total">
                                <?= number_format($item['price'] * $item['quantity'], 2) ?> €
                            </td>
                            <td>
                                <button class="btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <div class="cart-total">
                Total : <span><?= number_format($total, 2) ?> €</span>
            </div>

            <div class="cart-actions">
                <a href="home" class="btn-secondary">Continuer mes achats</a>
                <a href="cart_validation" class="btn-primary">
                    <i class="fa-solid fa-check"></i> Valider la commande
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>