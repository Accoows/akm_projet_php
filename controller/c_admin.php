<?php


// Define allowed sub-pages for the admin panel router
$sub = isset($_GET['sub']) ? $_GET['sub'] : 'index';
$allowed = ['index', 'users', 'articles', 'orders'];

if (!in_array($sub, $allowed)) {
    $sub = 'index'; // Fallback to index if sub-page is invalid
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;


// Handle deletion actions for different entities
if ($action === 'delete' && $id > 0) {
    if ($sub === 'users') {
        // Prevent admins from deleting their own account
        if ($_SESSION['user']['id'] !== $id) {
            try {
                $stmtDel = $pdo->prepare("DELETE FROM User WHERE id = ?");
                $stmtDel->execute([$id]);
            } catch (PDOException $e) {
                // Log error silently
            }
        }
    } elseif ($sub === 'articles') {
        try {
            
            $stmtImg = $pdo->prepare("SELECT image_link FROM Article WHERE id = ?");
            $stmtImg->execute([$id]);
            $article = $stmtImg->fetch();
            
            
            $stmtDelStock = $pdo->prepare("DELETE FROM Stock WHERE article_id = ?");
            $stmtDelStock->execute([$id]);

            
            $stmtDelCart = $pdo->prepare("DELETE FROM Cart WHERE article_id = ?");
            $stmtDelCart->execute([$id]);

            
            $stmtDelArt = $pdo->prepare("DELETE FROM Article WHERE id = ?");
            if ($stmtDelArt->execute([$id])) {
                
                if ($article && !empty($article['image_link'])) {
                    $imgPath = $article['image_link'];
                    if (file_exists($imgPath) && strpos($imgPath, 'uploads/articles/') === 0) {
                        unlink($imgPath);
                    }
                }
            }
        } catch (PDOException $e) {
            
        }
    }
    redirect("admin&sub={$sub}");
}


$userCount = 0;
$articleCount = 0;
$orderCount = 0;
$users = [];
$articles = [];

// Fetch data based on the requested sub-page
if ($sub === 'index') {
    try {
        // Fetch overall statistics for the dashboard
        $userCount = $pdo->query("SELECT COUNT(*) FROM User")->fetchColumn();
        $articleCount = $pdo->query("SELECT COUNT(*) FROM Article")->fetchColumn();
        $orderCount = $pdo->query("SELECT COUNT(*) FROM Invoice")->fetchColumn();
    } catch (PDOException $e) {
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
        // Fetch articles with their updated stock quantities
        $stmt = $pdo->query("SELECT a.*, s.quantity FROM Article a LEFT JOIN Stock s ON a.id = s.article_id ORDER BY a.id DESC");
        $articles = $stmt->fetchAll();
    } catch (PDOException $e) {
        $articles = [];
    }
} elseif ($sub === 'orders') {
    try {
        // Fetch invoices alongside the corresponding user details
        $stmt = $pdo->query("SELECT i.*, u.username, u.email FROM Invoice i LEFT JOIN User u ON i.user_id = u.id ORDER BY i.transaction_date DESC");
        $orders = $stmt->fetchAll();
    } catch (PDOException $e) {
        $orders = [];
    }
}
