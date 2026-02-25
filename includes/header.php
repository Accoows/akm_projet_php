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

        <div class="header-search">
            <form action="articles" method="GET" class="header-search-form">
                <?php if(isset($_GET['page'])): ?>
                    <input type="hidden" name="page" value="articles">
                <?php endif; ?>

                <div class="header-input-group">
                    <input type="text" name="q" placeholder="Rechercher..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>

        <nav>
            <ul>
                <li><a href="./">Accueil</a></li>
                <li><a href="articles">Catalogue</a></li>
                <?php if ($isLogged): ?>
                    <li><a href="cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    <li>
                        <a href="account" class="nav-avatar-btn">
                            <?php if (!empty($_SESSION['user']['profile_picture'])): ?>
                                <img src="<?= htmlspecialchars($_SESSION['user']['profile_picture']) ?>" alt="Avatar" class="nav-avatar-img">
                            <?php else: ?>
                                <i class="fa-solid fa-user-circle"></i>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li><a href="logout"><i class="fa-solid fa-right-from-bracket"></i></a></li>
                <?php else: ?>
                    <li><a href="login" class="btn-nav">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>