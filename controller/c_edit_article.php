<?php
// controller/c_edit_article.php

if (!isset($_SESSION['user'])) {
    redirect('login');
}

$articleId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$article = null;
$stock = null;

if ($articleId > 0) {
    // Récupérer l'article et son stock
    $stmt = $pdo->prepare("SELECT a.*, s.quantity FROM Article a LEFT JOIN Stock s ON a.id = s.article_id WHERE a.id = ?");
    $stmt->execute([$articleId]);
    $article = $stmt->fetch();
}

if (!$article) {
    die("Article introuvable.");
}

$isOwner = $_SESSION['user']['id'] == $article['author_id'];
$isAdmin = $_SESSION['user']['role'] === 'admin';

if (!$isOwner && !$isAdmin) {
    die("Vous n'avez pas l'autorisation de modifier cet article.");
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_btn'])) {
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
    
    // Image handling logic omitted for brevity, keeping old image if no new one uploaded
    $imagePath = $article['image_link'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed) && $_FILES['image']['size'] < 5 * 1024 * 1024) {
            $newFilename = uniqid() . '.' . $ext;
            $uploadDir = 'uploads/articles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newFilename)) {
                // Delete old image if it's in uploads
                if (file_exists($imagePath) && strpos($imagePath, 'uploads/articles/') === 0 && $imagePath != 'uploads/articles/bg1.png') {
                    unlink($imagePath);
                }
                $imagePath = $uploadDir . $newFilename;
            } else {
                $error = "Erreur upload image.";
            }
        } else {
            $error = "Format invalide ou fichier trop grand.";
        }
    }

    if (!$error && !empty($name) && $price !== false && $quantity !== false) {
        try {
            $pdo->beginTransaction();
            $stmtUpdate = $pdo->prepare("UPDATE Article SET name = ?, description = ?, price = ?, image_link = ? WHERE id = ?");
            $stmtUpdate->execute([$name, $description, $price, $imagePath, $articleId]);
            
            $stmtStockUpdate = $pdo->prepare("UPDATE Stock SET quantity = ? WHERE article_id = ?");
            $stmtStockUpdate->execute([$quantity, $articleId]);
            
            $pdo->commit();
            $success = "L'article a été mis à jour.";
            
            // Refresh data
            $article['name'] = $name;
            $article['description'] = $description;
            $article['price'] = $price;
            $article['quantity'] = $quantity;
            $article['image_link'] = $imagePath;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erreur lors de la mise à jour.";
        }
    } else {
        $error = "Données invalides.";
    }
}
?>
