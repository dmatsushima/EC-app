<?php

use App\Core\Router;
use App\Controllers\UserController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;
use App\Controllers\MypageController;
use App\Controllers\AdminOrderController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/helpers.php';

session_start(); // セッションの開始（カート機能に必要）

// コントローラーのインスタンス生成
$router = new Router();
$userController = new UserController();
$productController = new ProductController();
$cartController = new CartController();
$checkoutController = new CheckoutController();
$mypageController = new MypageController();
$adminOrderController = new AdminOrderController();

// --- GETルート ---
$router->get('/', function () use ($userController) {
    echo $userController->showLoginForm();
});

$router->get('/login', function () use ($userController) {
    echo $userController->showLoginForm();
});

$router->get('/register', function () use ($userController) {
    echo $userController->showRegisterForm();
});

$router->get('/products', function () use ($productController) {
    $productController->list();
});

$router->get('/product/{id}', function ($params) use ($productController) {
    $productController->detail((int)$params['id']);
});

// --- POSTルート ---
$router->post('/login', function () use ($userController) {
    echo $userController->login();
});

$router->post('/register', function () use ($userController) {
    echo $userController->register();
});

// ---  カート機能ルート追加 ---
// カート表示
$router->get('/cart', function () use ($cartController) {
    $cartController->index();
});

// カート追加
$router->post('/cart/add', function () use ($cartController) {
    $cartController->add();
});

// カート削除
$router->post('/cart/remove', function () use ($cartController) {
    $cartController->remove();
});

// ---  購入機能ルート追加 ---
$router->get('/checkout', function () use ($checkoutController) {
    $checkoutController->confirm();
});

$router->post('/checkout', function () use ($checkoutController) {
    $checkoutController->process();
});

// ---  マイページ機能ルート追加 ---
$router->get('/mypage', function () use ($mypageController) {
    $mypageController->index();
});

$router->get('/mypage/order/{id}', function ($params) use ($mypageController) {
    $mypageController->detail((int)$params['id']);
});

// ---  管理画面ルート追加 ---
$router->get('/admin/orders', function () use ($adminOrderController) {
    $adminOrderController->index();
});

$router->get('/admin/orders/{id}', function ($params) use ($adminOrderController) {
    $adminOrderController->detail((int)$params['id']);
});

// --- ルーティング実行 ---
$router->dispatch();

