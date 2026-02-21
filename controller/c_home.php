<?php

try {
    // Section 1
    $stmt1 = $pdo->query("SELECT * FROM Article ORDER BY publication_date DESC LIMIT 4");
    $latestArticles = $stmt1->fetchAll();
    // Section 2
    $stmt2 = $pdo->query("SELECT * FROM Article ORDER BY publication_date DESC LIMIT 4 OFFSET 4");
    $nextArticles = $stmt2->fetchAll();
} catch (PDOException $e) {
    $latestArticles = [];
    $nextArticles = [];
}
