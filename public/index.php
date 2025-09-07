<?php
declare(strict_types=1);
require dirname(__DIR__) . '/vendor/autoload.php';


use App\Controller\MainController;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad(); // no falla si falta .env

$config = require dirname(__DIR__) . '/config/config.php';
$controller = new MainController($config);
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'processEmployees':
        $controller->processEmployees();
        break;
    case 'processSales':
        $controller->processSales();
        break;
    case 'math':
        $controller->mathTools();
        break;
    case 'image':
        $controller->processImage();
        break;
    case 'mail':
        $controller->sendTestMail();
        break;
    default:
        $controller->home();
}