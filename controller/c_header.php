<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLogged = isset($_SESSION['user']);

if ($isLogged) {
    try {
        $stmtHeader = $pdo->prepare("SELECT profile_picture, username, role FROM User WHERE id = ?");
        $stmtHeader->execute([$_SESSION['user']['id']]);
        $headerUser = $stmtHeader->fetch();
        if ($headerUser) {
            $_SESSION['user']['profile_picture'] = $headerUser['profile_picture'];
            $_SESSION['user']['username'] = $headerUser['username'];
            $_SESSION['user']['role'] = $headerUser['role'];
        }
    } catch (PDOException $e) {
        
    }
}

$isAdmin = $isLogged && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
$scriptPath = str_replace('\\', '/', $scriptPath);
if (substr($scriptPath, -1) !== '/') {
    $scriptPath .= '/';
}
?>
