<?php
    require_once __DIR__ . '/sessions.php';
    require_once __DIR__ . '/functions.php';

    $envPath = realpath(dirname(__DIR__ ). '/.env');
    loadEnvVars($envPath);
    
    define('DS', DIRECTORY_SEPARATOR);
    define('BASE_PATH', realpath(dirname(__DIR__)));

    require_once __DIR__ . DS . 'db.php';
?>