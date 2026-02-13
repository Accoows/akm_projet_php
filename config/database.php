<?php
session_start();

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'php_project_pdo');

function getDB() {
    static $mysqli = null;
    
    if ($mysqli === null) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME) ? : die("Connection error : " . mysqli_connect_error());
        
        $mysqli->set_charset("utf8mb4");
    }
    
    return $mysqli;
}