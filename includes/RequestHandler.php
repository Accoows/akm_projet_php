<?php


class RequestHandler
{

    
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
        'stripe_success' => 'user',
        'sell' => 'user',

        'admin' => 'admin',
    ];

    
    public static function handle($page)
    {
        $requiredRole = isset(self::$routes[$page]) ? self::$routes[$page] : 'public';

        if ($requiredRole === 'public') {
            return; 
        }

        
        if (!isset($_SESSION['user'])) {
            redirect('login');
        }

        
        if ($requiredRole === 'admin') {
            if ($_SESSION['user']['role'] !== 'admin') {
                redirect('home');
            }
        }
    }
}
