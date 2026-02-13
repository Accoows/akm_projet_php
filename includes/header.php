<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Le chemin racine est maintenant géré via la balise <base> dans le HTML
$isLogged = isset($_SESSION['user']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATCFM - Équipement Tactique</title>

    <base href="/akm_projet_php/">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assets/css/script.css">
</head>

<body>

    <header>
        <div class="header-content">
            <a href="home" class="logo">
                <i class="fa-solid fa-shield-halved"></i> AT<span>CFM</span>
            </a>

            <nav>
                <ul>
                    <li><a href="home">Accueil</a></li>

                    <?php if ($isLogged): ?>
                        <li><a href="sell">Vendre</a></li>
                        <li><a href="cart"><i class="fa-solid fa-cart-shopping"></i> Panier</a></li>

                        <?php if ($isAdmin): ?>
                            <li><a href="admin" style="color:#e74c3c;">Admin</a></li>
                        <?php endif; ?>

                        <li><a href="account" class="btn-nav">Mon Compte</a></li>
                        <li><a href="logout"><i class="fa-solid fa-right-from-bracket"></i></a></li>

                    <?php else: ?>
                        <li><a href="register">Inscription</a></li>
                        <li><a href="login" class="btn-nav"><i class="fa-solid fa-user"></i> Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>