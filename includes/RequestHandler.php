<?php
// includes/RequestHandler.php

class RequestHandler
{

    /**
     * Define access levels for each page route.
     * Pages not listed here are assumed to be "public" by default.
     * 
     * Access levels:
     * - 'public' : Any visitor can access
     * - 'user'   : Must be logged in (any role)
     * - 'admin'  : Must be logged in AND have the 'admin' role
     */
    private static $routes = [
        'home' => 'public',
        'articles' => 'public',
        'detail' => 'public',
        'login' => 'public',
        'register' => 'public',
        '404' => 'public',

        'logout' => 'user',
        'account' => 'user',
        'cart' => 'user',
        'cart_validation' => 'user',
        'sell' => 'user',

        'admin' => 'admin',
    ];

    /**
     * Checks if the user is authorized to view the requested page.
     * Redirects to login or home if not authorized.
     */
    public static function handle($page)
    {
        $requiredRole = isset(self::$routes[$page]) ? self::$routes[$page] : 'public';

        if ($requiredRole === 'public') {
            return; // OK
        }

        // Both 'user' and 'admin' require user to be logged in
        if (!isset($_SESSION['user'])) {
            redirect('login');
        }

        // If route requires 'admin', check the user's role
        if ($requiredRole === 'admin') {
            if ($_SESSION['user']['role'] !== 'admin') {
                redirect('home');
            }
        }
    }
}
