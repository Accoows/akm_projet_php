<?php
// controller/c_delete_article.php

if (!isset($_SESSION['user'])) {
    redirect('login');
}

$articleId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($articleId > 0) {
    try {
        $stmtImg = $pdo->prepare("SELECT author_id, image_link FROM Article WHERE id = ?");
        $stmtImg->execute([$articleId]);
        $article = $stmtImg->fetch();

        if ($article) {
            $isOwner = $_SESSION['user']['id'] == $article['author_id'];
            $isAdmin = $_SESSION['user']['role'] === 'admin';

            if ($isOwner || $isAdmin) {
                // Delete stock
                $stmtDelStock = $pdo->prepare("DELETE FROM Stock WHERE article_id = ?");
                $stmtDelStock->execute([$articleId]);

                // Delete cart items
                $stmtDelCart = $pdo->prepare("DELETE FROM Cart WHERE article_id = ?");
                $stmtDelCart->execute([$articleId]);

                // Supprimer l'article en BDD
                $stmtDelArt = $pdo->prepare("DELETE FROM Article WHERE id = ?");
                if ($stmtDelArt->execute([$articleId])) {
                    // Supprimer l'image physique
                    if (!empty($article['image_link'])) {
                        $imgPath = $article['image_link'];
                        if (file_exists($imgPath) && strpos($imgPath, 'uploads/articles/') === 0 && $imgPath != 'uploads/articles/bg1.png') {
                            unlink($imgPath);
                        }
                    }
                }
            } else {
                die("Vous n'avez pas l'autorisation de supprimer cet article.");
            }
        }
    } catch (PDOException $e) {
        // Ignorer l'erreur pour ne pas bloquer
    }
}

redirect('articles');
?>
