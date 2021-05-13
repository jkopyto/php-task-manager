<?php 
//Rozpoczęcie sesji
session_start();

//Zmienne przechowujące dane logowania do bazy danych
// local
// define('DB_HOST', '127.0.0.1');
// dev
define('DB_HOST', 'db');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', '1234567890');
define('DB_NAME', 'task_manager');


//local
// define('SITEURL', 'http://localhost:8000/');

// dev
define('SITEURL', 'http://localhost/');

?>