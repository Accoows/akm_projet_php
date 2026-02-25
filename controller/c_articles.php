<?php


$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

$orderBy = "ORDER BY a.publication_date DESC"; // default

switch ($sort) {
    case 'price_asc':
        $orderBy = "ORDER BY a.price ASC";
        break;
    case 'price_desc':
        $orderBy = "ORDER BY a.price DESC";
        break;
    case 'name_asc':
        $orderBy = "ORDER BY a.name ASC";
        break;
    case 'name_desc':
        $orderBy = "ORDER BY a.name DESC";
        break;
    case 'oldest':
        $orderBy = "ORDER BY a.publication_date ASC";
        break;
    case 'newest':
    default:
        $orderBy = "ORDER BY a.publication_date DESC";
        break;
}

try {
    if ($searchQuery !== '') {
        $stmt = $pdo->prepare("SELECT a.*, u.username AS seller_name FROM Article a JOIN User u ON a.author_id = u.id WHERE a.name LIKE ? OR a.description LIKE ? $orderBy");
        $likeQuery = '%' . $searchQuery . '%';
        $stmt->execute([$likeQuery, $likeQuery]);
        $products = $stmt->fetchAll();
    } else {
        $stmt = $pdo->query("SELECT a.*, u.username AS seller_name FROM Article a JOIN User u ON a.author_id = u.id $orderBy");
        $products = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    $products = [];
}
