<?php

use App\Core\Router;
use App\Controllers\UserController;

require_once __DIR__ . '/../vendor/autoload.php';

// ルーターを初期化
$router = new Router();
$userController = new UserController();

// GETルート
$router->get('/', function () use ($userController) {
    echo $userController->showLoginForm();
});

$router->get('/login', function () use ($userController) {
    echo $userController->showLoginForm();
});

$router->get('/register', function () use ($userController) {
    echo $userController->showRegisterForm();
});

// POSTルート
$router->post('/login', function () use ($userController) {
    echo $userController->login();
});

$router->post('/register', function () use ($userController) {
    echo $userController->register();
});

// ルーティングを実行
$router->dispatch();
