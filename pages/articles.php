<?php
// pages/articles.php
$pageTitle = "Catalogue - Équipement Tactique";

// Mock data for products
$products = [
    [
        'id' => 1,
        'name' => 'Casque FAST Ballistique',
        'price' => 299.99,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Protection'
    ],
    [
        'id' => 2,
        'name' => 'Gilet Porte-Plaques JPC',
        'price' => 189.50,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Équipement'
    ],
    [
        'id' => 3,
        'name' => 'Gants Tactiques Renforcés',
        'price' => 34.90,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Accessoires'
    ],
    [
        'id' => 4,
        'name' => 'Sac à Dos 3 Jours',
        'price' => 89.99,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Bagagerie'
    ],
    [
        'id' => 5,
        'name' => 'Ceinturon Cobra',
        'price' => 45.00,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Accessoires'
    ],
    [
        'id' => 6,
        'name' => 'Poche Radio Molle',
        'price' => 19.99,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Équipement'
    ],
    [
        'id' => 7,
        'name' => 'Lunettes Balistiques',
        'price' => 55.00,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Protection'
    ],
    [
        'id' => 8,
        'name' => 'Bottes d\'Intervention',
        'price' => 125.00,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Chaussures'
    ]
];
?>

<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-layer-group"></i> Catalogue Complet
    </h2>

    <div class="grid-articles">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="article-content">
                    <div class="article-image">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <h3 class="article-title">
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>
                    <p class="article-category">
                        <?= htmlspecialchars($product['category']) ?>
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