<?php
// pages/admin.php

// Check admin permissions
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ./');
    exit();
}

$sub = isset($_GET['sub']) ? $_GET['sub'] : 'index';
$allowed = ['index', 'users', 'articles'];

if (!in_array($sub, $allowed)) {
    $sub = 'index';
}

$file = "pages/admin/{$sub}.php";

if (file_exists($file)) {
    include $file;
} else {
    include "pages/admin/index.php";
}
