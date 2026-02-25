<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/RequestHandler.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if (!preg_match('/^[a-z0-9_-]+$/i', $page)) {
    $page = '404';
}


RequestHandler::handle($page);

$controller_file = "controller/c_{$page}.php";
if (file_exists($controller_file)) {
    include $controller_file;
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