<?php
// pages/admin.php
// Redirects to or includes the main admin dashboard

// Check admin permissions again just in case
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ./');
    exit();
}

// Default to admin dashboard/index
include 'pages/admin/index.php';
