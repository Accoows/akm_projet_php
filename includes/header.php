<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLogged = isset($_SESSION['user']);
$isAdmin = $isLogged && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
$scriptPath = str_replace('\\', '/', $scriptPath);
if (substr($scriptPath, -1) !== '/') {
    $scriptPath .= '/';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATCFM - Équipement Tactique</title>

    <base href="<?= $scriptPath ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assets/css/script.css?v=<?= filemtime('assets/css/script.css'); ?>">
</head>

<body>

    <header>
        <!--======================================== -->
        <!-- DEV MENU -->
        <div class="dev-menu">
            <button class="dev-menu-btn"><i class="fa-solid fa-bars"></i></button>
            <div class="dev-menu-dropdown">
                <a href="./">Home</a>
                <a href="articles">Articles</a>
                <a href="login">Login</a>
                <a href="register">Register</a>
                <a href="account">Account</a>
                <a href="cart">Cart</a>
                <a href="cart_validation">Cart Validation</a>
                <a href="sell">Sell</a>
                <a href="admin">Admin Users</a>
                <a href="404">404 Page</a>
            </div>
        </div>
        <!--======================================== -->

        <div class="header-content">
            <a href="./" class="logo">
                <i class="fa-solid fa-shield-halved"></i> AT<span>CFM</span>
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