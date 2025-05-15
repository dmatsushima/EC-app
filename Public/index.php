<?php

use App\Core\Router;
use App\Controllers\UserController;
use App\Controllers\ProductController;

require_once __DIR__ . '/../vendor/autoload.php';

// ルーターを初期化
$router = new Router();
$userController = new UserController();
$productController = new ProductController();

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
$router->get('/products', function () use ($productController) {
    $productController->list();
});

$router->get('/product/{id}', function ($params) use ($productController) {
    $productController->detail((int)$params['id']);
});

// ルーティングを実行
$router->dispatch();
