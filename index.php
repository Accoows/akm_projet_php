<?php
session_start();


$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if (!preg_match('/^[a-z0-9_-]+$/i', $page)) {
    $page = '404';
}
if ($page === 'logout') {
    include 'pages/logout.php';
    exit();
}

include_once 'includes/header.php';
?>

<main class="container">
    <?php
    $target_file = "pages/{$page}.php";

    if (file_exists($target_file)) {
        include $target_file;
    } else {
        include 'pages/404.php';
    }
    ?>
</main>

<?php
include_once 'includes/footer.php';
?>