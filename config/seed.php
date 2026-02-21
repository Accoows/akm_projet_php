<?php
require_once 'database.php';

try {
    // 1. Nettoyage
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE Stock; TRUNCATE TABLE Cart; TRUNCATE TABLE Invoice; TRUNCATE TABLE Article; TRUNCATE TABLE User;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "--- Début du seeding ---<br>";

    // 2. Utilisateurs
    $users = [];
    $password = password_hash('password123', PASSWORD_BCRYPT);
    
    // Admin
    $users[] = ['admin', $password, 'admin@jrsoft.fr', 5000.00, 'assets/images/user_admin.png', 'admin'];
    
    // Clients
    $firstNames = ['Arthur', 'Thomas', 'Lucas', 'Maxime', 'Julien', 'Nicolas', 'Pierre', 'Paul', 'Louis', 'Antoine'];
    $lastNames = ['Dupont', 'Durand', 'Martin', 'Bernard', 'Petit', 'Robert', 'Richard', 'Simon', 'Michel', 'Lefebvre'];
    
    for ($i = 0; $i < 20; $i++) {
        $fn = $firstNames[array_rand($firstNames)];
        $ln = $lastNames[array_rand($lastNames)];
        $username = $fn . $ln . rand(10, 99);
        $email = strtolower($fn . '.' . $ln . rand(1, 100) . '@mail.fr');
        $users[] = [$username, $password, $email, rand(0, 500) + (rand(0, 99) / 100), 'assets/images/placeholder_user.png', 'user'];
    }

    $stmtUser = $pdo->prepare("INSERT INTO User (username, password, email, balance, profile_picture, role) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($users as $u) {
        $stmtUser->execute($u);
    }
    echo count($users) . " Utilisateurs créés.<br>";
    
    // Récupérer un ID admin pour les articles
    $stmtAdmin = $pdo->query("SELECT id FROM User WHERE role = 'admin' LIMIT 1");
    $adminId = $stmtAdmin->fetchColumn();

    // 3. Articles (Inspirés de jrsoft.fr - Airsoft & Tactique)
    $adjectives = ['Tactique', 'Renforcé', 'Mil-Spec', 'Camo', 'Noir', 'Tan', 'OD Green', 'Léger', 'Lourd', 'Modulable'];
    $nouns = [
        'Gilet Porte-Plaques', 'Casque Ballistique', 'Gants de Combat', 'Ceinturon Cobra', 
        'Sac à Dos Assault', 'Poche Radio', 'Holster Rigide', 'Sangle 2 Points', 
        'Genouillères', 'Masque de Protection', 'Bottes d\'Intervention', 'Veste Softshell',
        'Pantalon G3', 'Chemise de Combat', 'Lampe Tactique', 'Point Rouge', 'Lunette de Visée'
    ];
    
    $descriptions = [
        "Conçu pour les opérations les plus exigeantes. Matériaux haute résistance.",
        "Léger et durable, idéal pour l'airsoft et le tir sportif.",
        "Protection optimale sans sacrifier la mobilité.",
        "Système MOLLE complet pour une personnalisation totale.",
        "Résistant à l'eau et à l'abrasion. Testé sur le terrain.",
        "Ergonomie étudiée pour un confort longue durée.",
        "Compatible avec la plupart des standards du marché."
    ];

    $imageLinks = [
        'assets/images/bg1.png',
        'assets/images/bg2.png',
    ];

    $articles = [];
    for ($i = 0; $i < 50; $i++) {
        $name = $nouns[array_rand($nouns)] . ' ' . $adjectives[array_rand($adjectives)];
        if (rand(0, 1)) $name .= ' V' . rand(1, 5);
        
        $desc = $descriptions[array_rand($descriptions)] . " " . $descriptions[array_rand($descriptions)];
        $price = rand(15, 300) + (rand(0, 99) / 100);
        $image = $imageLinks[array_rand($imageLinks)];
        
        $articles[] = [$name, $desc, $price, $adminId, $image];
    }

    $stmtArt = $pdo->prepare("INSERT INTO Article (name, description, price, author_id, image_link, publication_date) VALUES (?, ?, ?, ?, ?, NOW() - INTERVAL ? DAY)");
    $stmtStock = $pdo->prepare("INSERT INTO Stock (article_id, quantity) VALUES (?, ?)");

    foreach ($articles as $a) {
        // Ajout d'un intervalle aléatoire pour la date
        $daysAgo = rand(0, 30);
        $params = $a;
        $params[] = $daysAgo; // Ajout du paramètre pour INTERVAL
        
        $stmtArt->execute($params);
        $articleId = $pdo->lastInsertId();
        
        // Stock aléatoire
        $stmtStock->execute([$articleId, rand(0, 100)]);
    }
    echo count($articles) . " Articles et Stocks générés.<br>";

    echo "--- Seeding terminé avec succès ! ---";

} catch (Exception $e) {
    die("Erreur lors du seeding : " . $e->getMessage());
}