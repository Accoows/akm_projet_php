<?php
// pages/detail.php

// Mock data (matches articles.php)
$products = [
    [
        'id' => 1,
        'name' => 'Casque FAST Ballistique',
        'price' => 299.99,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Protection',
        'description' => 'Un casque léger et robuste, conçu pour les opérations spéciales. Offre une protection balistique de niveau IIIA.'
    ],
    [
        'id' => 2,
        'name' => 'Gilet Porte-Plaques JPC',
        'price' => 189.50,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Équipement',
        'description' => 'Gilet porte-plaques minimaliste pour une mobilité maximale. Compatible avec les plaques SAPI standard.'
    ],
    [
        'id' => 3,
        'name' => 'Gants Tactiques Renforcés',
        'price' => 34.90,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Accessoires',
        'description' => 'Gants avec protection des jointures et paume renforcée pour une prise en main optimale.'
    ],
    [
        'id' => 4,
        'name' => 'Sac à Dos 3 Jours',
        'price' => 89.99,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Bagagerie',
        'description' => 'Sac à dos grande capacité avec système MOLLE, idéal pour les patrouilles de longue durée.'
    ],
    [
        'id' => 5,
        'name' => 'Ceinturon Cobra',
        'price' => 45.00,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Accessoires',
        'description' => 'Ceinturon tactique rigide avec boucle Cobra authentique. Supporte le poids de votre équipement sans fléchir.'
    ],
    [
        'id' => 6,
        'name' => 'Poche Radio Molle',
        'price' => 19.99,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Équipement',
        'description' => 'Poche universelle pour radio, compatible avec la plupart des modèles portatifs.'
    ],
    [
        'id' => 7,
        'name' => 'Lunettes Balistiques',
        'price' => 55.00,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Protection',
        'description' => 'Lunettes de protection certifiées, avec verres interchangeables et traitement anti-buée.'
    ],
    [
        'id' => 8,
        'name' => 'Bottes d\'Intervention',
        'price' => 125.00,
        'image' => 'assets/images/placeholder.png',
        'category' => 'Chaussures',
        'description' => 'Bottes légères et résistantes, offrant un excellent maintien de la cheville et une semelle antidérapante.'
    ]
];

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = null;

// Find product
foreach ($products as $p) {
    if ($p['id'] === $product_id) {
        $product = $p;
        break;
    }
}

$pageTitle = $product ? $product['name'] : "Produit introuvable";
?>

<div class="container">
    <?php if ($product): ?>
        <div class="product-detail-container">
            <div class="detail-image">
                <i class="fa-solid fa-image"></i>
            </div>
            <div class="detail-info">
                <h2 class="detail-title">
                    <?= htmlspecialchars($product['name']) ?>
                </h2>
                <span class="detail-category">
                    <?= htmlspecialchars($product['category']) ?>
                </span>
                <div class="detail-price">
                    <?= number_format($product['price'], 2) ?> €
                </div>

                <p class="detail-description">
                    <?= htmlspecialchars($product['description']) ?>
                </p>

                <div class="detail-actions">
                    <button class="btn-primary">
                        <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                    </button>
                    <a href="articles" class="btn-secondary" style="text-decoration: none;">
                        <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
                    </a>
                </div>
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