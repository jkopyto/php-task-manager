<?php 
//Rozpoczęcie sesji
session_start();

function siteURL() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol.$domainName;
}

//Zmienne przechowujące dane logowania do bazy danych
// local
// define('DB_HOST', '127.0.0.1');

// dev
define('DB_HOST', 'db');

define('DB_USERNAME', 'user');
define('DB_PASSWORD', '1234567890');
define('DB_NAME', 'task_manager');
define('SITEURL', siteURL().'/');

?>