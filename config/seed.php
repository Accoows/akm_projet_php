<?php
require_once 'database.php';

try {
    // 1. Nettoyage (on repart sur du propre)
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE Stock; TRUNCATE TABLE Cart; TRUNCATE TABLE Invoice; TRUNCATE TABLE Article; TRUNCATE TABLE User;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "--- Initialisation de la base JRSOFT ---<br>";

    // 2. Création des Utilisateurs
    $password = password_hash('password123', PASSWORD_BCRYPT);

    // Insertion Admin (Compte test par défaut)
    $pdo->prepare("INSERT INTO User (username, password, email, balance, profile_picture, role) VALUES (?, ?, ?, ?, ?, ?)")
        ->execute(['Admin', $password, 'admin@jrsoft.fr', 9999.99, 'assets/images/logo.png', 'admin']);

    $adminId = $pdo->lastInsertId();

    // Insertion de 10 clients aléatoires
    $firstNames = ['Arthur', 'Thomas', 'Lucas', 'Maxime', 'Julien'];
    $lastNames = ['Dupont', 'Durand', 'Martin', 'Bernard', 'Petit'];

    $stmtUser = $pdo->prepare("INSERT INTO User (username, password, email, balance, profile_picture, role) VALUES (?, ?, ?, ?, ?, ?)");
    for ($i = 0; $i < 10; $i++) {
        $username = $firstNames[array_rand($firstNames)] . rand(10, 99);
        $email = strtolower($username . "@mail.fr");
        $stmtUser->execute([$username, $password, $email, rand(50, 500), 'assets/images/logo_atcfm.png', 'user']);
    }

    // 3. Articles basés sur TES fichiers (image_97b2dc.webp)
    $realItems = [
        ['Gilet Porte-Plaques Lourd', 'gilet1.webp', 'Gilet tactique haute résistance avec système MOLLE et compartiments plaques.', 129.90],
        ['Bottes Commando Desert', 'bottes1.webp', 'Bottes légères et respirantes pour opérations en milieu aride.', 85.00],
        ['Casque FAST MH Noir', 'hat1.webp', 'Casque tactique avec rails latéraux et montage NVG frontal.', 55.50],
        ['Pistolet Gaz G17 Blowback', 'pistolgaz.webp', 'Réplique de poing ultra-réaliste avec culasse mobile.', 145.00],
        ['Gants de Combat Coqués', 'gants1.webp', 'Gants renforcés offrant une protection optimale des phalanges.', 29.99],
        ['Viseur Point Rouge Micro', 'viseur.webp', 'Optique de visée rapide pour acquisition de cible instantanée.', 42.00],
        ['Holster Rigide Universel', 'holster.webp', 'Holster en polymère avec système de rétention active.', 35.00],
        ['Masque Balistique Grillagé', 'masque1.webp', 'Protection faciale indispensable contre les impacts.', 19.50],
        ['Couteau d\'entraînement', 'couteau1.webp', 'Réplique factice en caoutchouc pour l\'entraînement tactique.', 15.00],
        ['Sac à Dos Assault 30L', 'bp1.webp', 'Sac compact avec de nombreux compartiments pour vos missions.', 49.00],
        ['Carabine AEG M4 RIS', 'carabine.webp', 'Fusil d\'assaut électrique polyvalent avec garde-main rail.', 289.00],
        ['Pack Billes 0.25g (3000pcs)', 'bille1.webp', 'Billes de haute précision polies pour un groupement parfait.', 12.90]
    ];

    $stmtArt = $pdo->prepare("INSERT INTO Article (name, description, price, author_id, image_link, publication_date) VALUES (?, ?, ?, ?, ?, NOW() - INTERVAL ? DAY)");
    $stmtStock = $pdo->prepare("INSERT INTO Stock (article_id, quantity) VALUES (?, ?)");

    // Insertion des articles réels
    foreach ($realItems as $item) {
        $stmtArt->execute([$item[0], $item[2], $item[3], $adminId, 'uploads/articles/' . $item[1], rand(0, 10)]);
        $stmtStock->execute([$pdo->lastInsertId(), rand(5, 50)]);
    }

    // On complète à 50 articles avec des variantes (Génération procédurale)
    for ($i = 0; $i < 38; $i++) {
        $name = "Équipement Modulable V" . rand(1, 9);
        $desc = "Produit tactique complémentaire testé sur le terrain. Robustesse assurée.";
        $stmtArt->execute([$name, $desc, rand(20, 200), $adminId, 'uploads/articles/bg1.png', rand(10, 30)]);
        $stmtStock->execute([$pdo->lastInsertId(), rand(0, 100)]);
    }

    echo "--- Seeding terminé : 50 Articles en stock ! ---";

} catch (Exception $e) {
    die("Erreur Fatale Seeder : " . $e->getMessage());
}