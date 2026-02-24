<?php
// controller/c_header.php

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
