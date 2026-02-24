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
        ['Pack Billes 0.25g (3000pcs)', 'bille1.webp', 'Billes de haute précision polies pour un groupement parfait.', 12.90],
        ['Fusil AEG 35', 'aeg35.webp', 'Fusil d\'assaut électrique compact idéal pour le CQB.', 199.90],
        ['Batterie LiPo 7.4V', 'batterie.webp', 'Batterie haute performance pour répliques électriques.', 24.50],
        ['Pack Billes 0.28g', 'bille2.webp', 'Billes lourdes pour une meilleure stabilité en vol.', 14.90],
        ['Bombe Gaz Green Gas', 'bombegaz1.webp', 'Gaz lubrifié pour répliques GBB et GBBR.', 11.50],
        ['Bombe Gaz Sec', 'bombegaz2.webp', 'Gaz sans silicone pour un fonctionnement optimal par temps froid.', 12.00],
        ['Bottes Tactiques Noires', 'bottes2.webp', 'Bottes robustes et imperméables avec semelle antidérapante.', 89.90],
        ['Sac à Dos Assault 45L', 'bp2.webp', 'Sac à dos grande capacité pour les longues missions.', 65.00],
        ['Chargeur M4 Mid-Cap', 'chargeur1.webp', 'Chargeur 120 billes en polymère, pas de bruit de maracas.', 15.90],
        ['Chargeur AK High-Cap', 'chargeur2.webp', 'Chargeur 600 billes en métal pour un tir soutenu.', 18.50],
        ['Chargeur G17 Gaz', 'chargeur3.webp', 'Chargeur supplémentaire pour pistolet G17, capacité 23 billes.', 25.00],
        ['Couteau Tactique M9', 'couteau2.webp', 'Couteau d\'entraînement type baïonnette M9.', 16.50],
        ['Gants Mitaines Coqués', 'gants2.webp', 'Gants de combat sans doigts pour une meilleure dextérité.', 22.00],
        ['Gilet Porte-Plaques Léger', 'gilet2.webp', 'Gilet JPC minimaliste pour une grande mobilité.', 75.00],
        ['Chest Rig Tactique', 'gilet3.webp', 'Gilet d\'assaut léger parfait pour les configurations rapides.', 45.00],
        ['Casque MICH 2000 Desert', 'hat2.webp', 'Casque de protection avec pad intérieur réglable.', 48.00],
        ['Huile Silicone Spray', 'huilepistol1.webp', 'Lubrifiant indispensable pour l\'entretien de vos répliques.', 8.50],
        ['Graisse Téflon', 'huilepistol2.webp', 'Graisse épaisse pour les engrenages de gearbox.', 9.00],
        ['Lampe Tactique 500 Lumens', 'lampe1.webp', 'Lampe puissante avec fixation pour rail Picatinny.', 38.00],
        ['Lampe Frontale Militaire', 'lampe2.webp', 'Lampe frontale discrète avec modes blanc et rouge.', 25.50],
        ['Lance-Grenades M203', 'lancegrenade.webp', 'Lance-grenades sous canon pour répliques type M4.', 85.00],
        ['Masque Néoprène Demi-Visage', 'masque2.webp', 'Masque souple et confortable pour la protection du bas du visage.', 12.00],
        ['Lunettes de Protection Balistique', 'masque3.webp', 'Lunettes de tir norme EN166 avec verres interchangeables.', 24.50],
        ['Grenade Sonore Tornado', 'nade1.webp', 'Grenade réutilisable à gaz avec effet sonore puissant.', 65.00],
        ['Grenade à Main Factice', 'nade2.webp', 'Grenade décorative et d\'entraînement style M67.', 14.00],
        ['Piles CR123A (Pack de 2)', 'pile.webp', 'Piles longue durée pour lampes et lasers tactiques.', 7.50],
        ['Pantalon Treillis Camo', 'pontalon.webp', 'Pantalon résistant avec genouillères intégrées.', 45.00],
        ['Poche Chargeur Double', 'portemag.webp', 'Poche MOLLE pour deux chargeurs type M4/M16.', 16.00],
        ['Pistolet Mitrailleur Scorpion EVO', 'scorpion.webp', 'Réplique SMG compacte et nerveuse, idéale en bâtiment.', 349.00],
        ['Grenade Fumigène Blanche', 'smoke1.webp', 'Fumigène à goupille pour masquage tactique, durée 60s.', 8.50],
        ['Grenade Fumigène Rouge', 'smoke2.webp', 'Fumigène de signalisation rouge intense.', 8.50],
        ['Fusil Snipe Zion Arms', 'zion.webp', 'Fusil de précision à ressort avec lunette incluse.', 185.00]
    ];

    $stmtArt = $pdo->prepare("INSERT INTO Article (name, description, price, author_id, image_link, publication_date) VALUES (?, ?, ?, ?, ?, NOW() - INTERVAL ? DAY)");
    $stmtStock = $pdo->prepare("INSERT INTO Stock (article_id, quantity) VALUES (?, ?)");

    // Insertion des articles réels
    foreach ($realItems as $item) {
        $stmtArt->execute([$item[0], $item[2], $item[3], $adminId, 'uploads/articles/' . $item[1], rand(0, 10)]);
        $stmtStock->execute([$pdo->lastInsertId(), rand(5, 50)]);
    }

    echo "--- Seeding terminé : " . count($realItems) . " Articles en stock ! ---";

} catch (Exception $e) {
    die("Erreur Fatale Seeder : " . $e->getMessage());
}