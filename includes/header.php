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

    <link rel="stylesheet" href="assets/css/base.css?v=<?= filemtime('assets/css/base.css'); ?>">
    <link rel="stylesheet" href="assets/css/layout.css?v=<?= filemtime('assets/css/layout.css'); ?>">
    <link rel="stylesheet" href="assets/css/components.css?v=<?= filemtime('assets/css/components.css'); ?>">
    <link rel="stylesheet" href="assets/css/pages.css?v=<?= filemtime('assets/css/pages.css'); ?>">
    <link rel="stylesheet" href="assets/css/admin.css?v=<?= filemtime('assets/css/admin.css'); ?>">
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
                    <li><a href="sell">Vendre</a></li>
                    <li><a href="cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                    <li class="nav-dropdown">
                        <a href="account" class="nav-avatar-btn">
                            <?php if (!empty($_SESSION['user']['profile_picture'])): ?>
                                <img src="<?= htmlspecialchars($_SESSION['user']['profile_picture']) ?>" alt="Avatar" class="nav-avatar-img">
                            <?php else: ?>
                                <i class="fa-solid fa-user-circle"></i>
                            <?php endif; ?>
                            <i class="fa-solid fa-chevron-down" style="font-size: 0.7em; margin-left: 5px;"></i>
                        </a>
                        <ul class="nav-dropdown-menu">
                            <li><a href="account"><i class="fa-solid fa-user"></i> Mon compte</a></li>
                            <?php if (isset($isAdmin) && $isAdmin): ?>
                                <li><a href="admin"><i class="fa-solid fa-gauge"></i> Admin</a></li>
                            <?php endif; ?>
                            <li><a href="logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="login" class="btn-nav">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>