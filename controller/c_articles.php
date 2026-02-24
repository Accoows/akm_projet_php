<?php
// controller/c_articles.php

try {
    $stmt = $pdo->query("SELECT a.*, u.username AS seller_name FROM Article a JOIN User u ON a.author_id = u.id");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
