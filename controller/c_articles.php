<?php
// controller/c_articles.php
$pageTitle = "Catalogue - Équipement Tactique";

try {
    $stmt = $pdo->query("SELECT * FROM article");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
