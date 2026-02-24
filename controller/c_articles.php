<?php


$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

try {
    if ($searchQuery !== '') {
        $stmt = $pdo->prepare("SELECT a.*, u.username AS seller_name FROM Article a JOIN User u ON a.author_id = u.id WHERE a.name LIKE ? OR a.description LIKE ? ORDER BY a.id DESC");
        $likeQuery = '%' . $searchQuery . '%';
        $stmt->execute([$likeQuery, $likeQuery]);
        $products = $stmt->fetchAll();
    } else {
        $stmt = $pdo->query("SELECT a.*, u.username AS seller_name FROM Article a JOIN User u ON a.author_id = u.id ORDER BY a.id DESC");
        $products = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    $products = [];
}
