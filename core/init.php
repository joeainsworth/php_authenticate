<?php
session_start();

// This can be changed to use the new DEFINE
$GLOBALS['config'] = [
    'mysql' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'username' => 'joeainsworth',
        'password' => '',
        'db' => 'website'
    ],
    'remember' => [
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ],
    'session' => [
        'session_name' => 'user',
        'token_name' => 'token'
    ]
];

spl_autoload_register(function($class) {
    require_once "classes/{$class}.php";
});

require_once 'functions/sanitize.php';