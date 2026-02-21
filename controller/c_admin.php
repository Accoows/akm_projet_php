<?php
// controller/c_admin.php

$sub = isset($_GET['sub']) ? $_GET['sub'] : 'index';
$allowed = ['index', 'users', 'articles'];

if (!in_array($sub, $allowed)) {
    $sub = 'index';
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Handle Delete Actions
if ($action === 'delete' && $id > 0) {
    if ($sub === 'users') {
        // Prevent deleting oneself
        if ($_SESSION['user']['id'] !== $id) {
            try {
                $stmtDel = $pdo->prepare("DELETE FROM User WHERE id = ?");
                $stmtDel->execute([$id]);
            } catch (PDOException $e) {
                // Ignore constraint errors
            }
        }
    } elseif ($sub === 'articles') {
        try {
            // Delete stock first
            $stmtDelStock = $pdo->prepare("DELETE FROM Stock WHERE article_id = ?");
            $stmtDelStock->execute([$id]);

            // Delete cart items
            $stmtDelCart = $pdo->prepare("DELETE FROM Cart WHERE article_id = ?");
            $stmtDelCart->execute([$id]);

            $stmtDelArt = $pdo->prepare("DELETE FROM Article WHERE id = ?");
            $stmtDelArt->execute([$id]);
        } catch (PDOException $e) {
            // Ignore constraint errors
        }
    }
    redirect("admin&sub={$sub}");
}

// Data fetching based on sub
$userCount = 0;
$articleCount = 0;
$orderCount = 0;
$users = [];
$articles = [];

if ($sub === 'index') {
    try {
        $userCount = $pdo->query("SELECT COUNT(*) FROM User")->fetchColumn();
        $articleCount = $pdo->query("SELECT COUNT(*) FROM Article")->fetchColumn();
        $orderCount = $pdo->query("SELECT COUNT(*) FROM Invoice")->fetchColumn();
    } catch (PDOException $e) {
        // Silent error
    }
} elseif ($sub === 'users') {
    try {
        $stmt = $pdo->query("SELECT * FROM User ORDER BY id DESC");
        $users = $stmt->fetchAll();
    } catch (PDOException $e) {
        $users = [];
    }
} elseif ($sub === 'articles') {
    try {
        $stmt = $pdo->query("SELECT a.*, s.quantity FROM Article a LEFT JOIN Stock s ON a.id = s.article_id ORDER BY a.id DESC");
        $articles = $stmt->fetchAll();
    } catch (PDOException $e) {
        $articles = [];
    }
}
