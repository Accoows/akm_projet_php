<?php

try {
    // Fetch the 4 most recently published articles for the primary display
    $stmt1 = $pdo->query("SELECT a.*, u.username AS seller_name FROM Article a JOIN User u ON a.author_id = u.id ORDER BY a.publication_date DESC LIMIT 4");
    $latestArticles = $stmt1->fetchAll();
    
    // Fetch the following 4 articles for the secondary section using a pagination offset
    $stmt2 = $pdo->query("SELECT a.*, u.username AS seller_name FROM Article a JOIN User u ON a.author_id = u.id ORDER BY a.publication_date DESC LIMIT 4 OFFSET 4");
    $nextArticles = $stmt2->fetchAll();
} catch (PDOException $e) {
    $latestArticles = [];
    $nextArticles = [];
}
