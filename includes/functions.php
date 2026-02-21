<?php
// includes/functions.php

/**
 * Redirects to a specified URL and exits.
 * @param string $url The URL or page to redirect to (e.g. 'home', 'login')
 */
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

/**
 * Checks if the current request is a POST request.
 * @return bool
 */
function isPost()
{
    return $_SERVER["REQUEST_METHOD"] === "POST";
}

/**
 * Sanitizes string input to prevent XSS.
 * @param string $input
 * @return string
 */
function sanitize($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Ensures the user is logged in. Redirects to login if not.
 * @return int User ID if logged in
 */
function requireLogin()
{
    if (!isset($_SESSION['user'])) {
        redirect('login');
    }
    return $_SESSION['user']['id'];
}

/**
 * Ensures the user is an admin. Redirects to home if not.
 * @return array The user session array
 */
function requireAdmin()
{
    requireLogin();
    if ($_SESSION['user']['role'] !== 'admin') {
        redirect('home');
    }
    return $_SESSION['user'];
}
