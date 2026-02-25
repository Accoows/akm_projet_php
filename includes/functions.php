<?php

function redirect($url)
{
    header("Location: " . $url);
    exit();
}


function isPost()
{
    return $_SERVER["REQUEST_METHOD"] === "POST";
}


function sanitize($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


function requireLogin()
{
    if (!isset($_SESSION['user'])) {
        redirect('login');
    }
    return $_SESSION['user']['id'];
}


function requireAdmin()
{
    requireLogin();
    if ($_SESSION['user']['role'] !== 'admin') {
        redirect('home');
    }
    return $_SESSION['user'];
}
