<?php
require_once 'database.php';

try {
    // 1. Nettoyage (Optionnel : vide les tables pour repartir à zéro)
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE Stock; TRUNCATE TABLE Cart; TRUNCATE TABLE Article; TRUNCATE TABLE User;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "--- Début du seeding ---<br>";

    // 2. Insertion des Utilisateurs (Mdp: 'password123')
    $password = password_hash('password123', PASSWORD_BCRYPT);

    $users = [
        ['admin', $password, 'admin@jrsoft.tp', 1000.00, 'logo.png', 'admin'],
        ['David', $password, 'david@mail.fr', 150.50, 'user1.png', 'user'],
        ['JohnTactical', $password, 'john@ops.com', 50.00, 'user2.png', 'user']
    ];

    $stmtUser = $pdo->prepare("INSERT INTO User (username, password, email, balance, profile_picture, role) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($users as $u) {
        $stmtUser->execute($u);
    }
    echo "Utilisateurs créés !<br>";

    // 3. Insertion des Articles
    $adminId = $pdo->lastInsertId() - 2; // Récupère l'ID de l'admin

    $articles = [
        ['Gilet Tactique V2', 'Protection balistique légère avec système MOLLE.', 89.99, $adminId, 'assets/css/bg1.png'],
        ['Casque FAST Carbon', 'Casque ultra-léger pour opérations nocturnes.', 120.00, $adminId, 'assets/css/bg2.png'],
        ['Gants Coqués', 'Protection maximale des phalanges et grip optimisé.', 25.50, $adminId, 'assets/css/bg1.png'],
        ['Holster Polymère', 'Dégainage rapide compatible Glock 17/19.', 45.00, $adminId, 'assets/css/bg2.png'],
        ['Sac à dos 45L', 'Compartiment hydratation et étanche.', 75.00, $adminId, 'assets/css/bg1.png'],
        ['Lunettes Balistiques', 'Norme ANSI Z87.1, anti-buée.', 35.00, $adminId, 'assets/css/bg2.png']
    ];

    $stmtArt = $pdo->prepare("INSERT INTO Article (name, description, price, author_id, image_link) VALUES (?, ?, ?, ?, ?)");
    $stmtStock = $pdo->prepare("INSERT INTO Stock (article_id, quantity) VALUES (?, ?)");

    foreach ($articles as $a) {
        $stmtArt->execute($a);
        $articleId = $pdo->lastInsertId();

        // 4. On remplit le Stock en même temps
        $stmtStock->execute([$articleId, rand(5, 50)]);
    }
    echo "Articles et Stocks initialisés !<br>";

    echo "--- Seeding terminé avec succès ! ---";

} catch (Exception $e) {
    die("Erreur lors du seeding : " . $e->getMessage());
}