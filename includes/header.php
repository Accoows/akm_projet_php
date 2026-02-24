<?php
require_once 'controller/c_header.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATCFM - Équipement Tactique</title>
    
    <link rel="icon" type="image/x-icon" href="assets/images/logo_atcfm.ico">

    <base href="<?= $scriptPath ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assets/css/script.css?v=<?= filemtime('assets/css/script.css'); ?>">
</head>

<body>

    <header>
        <div class="header-content">
            <a href="./" class="logo">
                <img src="assets/images/logo_atcfm_bg.webp" alt="ATCFM Logo">
            </a>

            <nav>
                <ul>
                    <li><a href="./">Accueil</a></li>
                    <li><a href="articles">Catalogue</a></li>

                    <?php if ($isLogged): ?>
                        <li><a href="sell">Vendre</a></li>
                        <li><a href="cart"><i class="fa-solid fa-cart-shopping"></i> Panier</a></li>

                        <?php if ($isAdmin): ?>
                            <li><a href="admin" class="nav-link-admin">Admin</a></li>
                        <?php endif; ?>

                        <li>
                            <a href="account" class="btn-nav nav-avatar-btn">
                                <?php if (!empty($_SESSION['user']['profile_picture'])): ?>
                                    <img src="<?= htmlspecialchars($_SESSION['user']['profile_picture']) ?>" alt="Avatar" class="nav-avatar-img">
                                <?php else: ?>
                                    <i class="fa-solid fa-user-circle"></i>
                                <?php endif; ?>
                                Mon Compte
                            </a>
                        </li>
                        <li><a href="logout"><i class="fa-solid fa-right-from-bracket"></i></a></li>

                    <?php else: ?>
                        <li><a href="register">Inscription</a></li>
                        <li><a href="login" class="btn-nav"><i class="fa-solid fa-user"></i> Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>