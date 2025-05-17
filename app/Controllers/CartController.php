<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Cart;
use App\Models\Product;

class CartController extends BaseController
{
    private Product $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product(); // 既存のProductクラスをインスタンス化
    }

    public function index()
    {
        $cart_items = Cart::getItems();
        $products = [];

        foreach ($cart_items as $product_id => $qty) {
            $product = $this->productModel->getProductById($product_id);
            if ($product) {
                $product['quantity'] = $qty;
                $products[] = $product;
            }
        }

        echo $this->render('cart/index.twig', ['products' => $products]);
    }

    public function add()
    {
        $product_id = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($product_id > 0) {
            Cart::addItem($product_id, $quantity);
        }

        header('Location: /cart');
        exit;
    }

    public function remove()
    {
        $product_id = (int)($_POST['product_id'] ?? 0);
        if ($product_id > 0) {
            Cart::removeItem($product_id);
        }

        header('Location: /cart');
        exit;
    }
}

