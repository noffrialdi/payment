<?php

include("config/db.php");

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request)["path"];

switch ($path) {
    case '':
    case '/':
        require __DIR__ . '/views/home.php';
        break;

    case '/payment':
        require __DIR__ . '/controllers/payment.php';
        break;

    case '/payment/check':
        require __DIR__ . '/controllers/check_payment.php';
        break;

    case '/phpinfo':
        require 'phpinfo.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';

}

