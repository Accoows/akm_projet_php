<?php
// controller/c_detail.php

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = null;

if ($product_id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT a.*, s.quantity AS stock_quantity, u.username AS seller_name FROM Article a LEFT JOIN Stock s ON a.id = s.article_id JOIN User u ON a.author_id = u.id WHERE a.id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
    } catch (PDOException $e) {
        $product = null;
    }
}

$pageTitle = $product ? $product['name'] : "Produit introuvable";
