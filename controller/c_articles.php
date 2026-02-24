<?php
// controller/c_articles.php

try {
    $stmt = $pdo->query("SELECT * FROM article");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
