<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définition du chemin racine par défaut si non défini
if (!isset($path)) {
    $path = "./";
}

$isLogged = isset($_SESSION['user']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JRSOFT - Équipement Tactique</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="<?= $path ?>assets/css/script.css">
</head>
<body>

<header>
    <div class="header-content">
        <a href="<?= $path ?>index.php?page=home" class="logo">
            <i class="fa-solid fa-shield-halved"></i> JR<span>SOFT</span>
        </a>

        <nav>
            <ul>
                <li><a href="<?= $path ?>index.php?page=home">Accueil</a></li>
                
                <?php if ($isLogged): ?>
                    <li><a href="<?= $path ?>index.php?page=sell">Vendre</a></li>
                    <li><a href="<?= $path ?>index.php?page=cart"><i class="fa-solid fa-cart-shopping"></i> Panier</a></li>
                    
                    <?php if ($isAdmin): ?>
                        <li><a href="<?= $path ?>index.php?page=admin" style="color:#e74c3c;">Admin</a></li>
                    <?php endif; ?>

                    <li><a href="<?= $path ?>index.php?page=account" class="btn-nav">Mon Compte</a></li>
                    <li><a href="<?= $path ?>index.php?page=logout"><i class="fa-solid fa-right-from-bracket"></i></a></li>
                
                <?php else: ?>
                    <li><a href="<?= $path ?>index.php?page=register">Inscription</a></li>
                    <li><a href="<?= $path ?>index.php?page=login" class="btn-nav"><i class="fa-solid fa-user"></i> Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>