<?php
// controller/c_detail.php

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = null;

if ($product_id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM article WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
    } catch (PDOException $e) {
        $product = null;
    }
}

$pageTitle = $product ? $product['name'] : "Produit introuvable";
