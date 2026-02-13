<?php 
$path = "./"; 

include_once 'includes/header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
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
            echo "<h2>Erreur 404 : Page introuvable</h2>";
            break;
    }
    ?>
</main>

<?php 
// 4. Inclusion du pied de page
include_once 'includes/footer.php'; 
?>