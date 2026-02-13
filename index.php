<?php 
session_start();
$path = "./"; 

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($page === 'logout') {
    include 'pages/logout.php';
    exit();
}

include_once 'includes/header.php';
?>

<main class="container">
    <?php
    switch ($page) {
        case 'home':
            include 'pages/home.php'; 
            break;

        case 'account':
            if (file_exists('pages/account.php')) {
                include 'pages/account.php';
            } else {
                echo "<p>Erreur : Le fichier account.php est introuvable.</p>";
            }
            break;
            
        case 'login':
            include 'pages/login.php';
            break;

        case 'register':
            include 'pages/register.php';
            break;

        default:
            include 'pages/404.php';
            break;
    }
    ?>
</main>

<?php 
include_once 'includes/footer.php'; 
?>