<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

class CheckoutController extends BaseController
{
    private Product $productModel;
    private Order $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    public function confirm()
    {
        $items = [];
        foreach (Cart::getItems() as $product_id => $qty) {
            $product = $this->productModel->getProductById($product_id);
            if ($product) {
                $product['quantity'] = $qty;
                $items[] = $product;
            }
        }

        echo $this->render('checkout/confirm.twig', ['products' => $items]);
    }

    public function process()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            header('Location: /login');
            exit;
        }

        $items = [];
        foreach (Cart::getItems() as $product_id => $qty) {
            $product = $this->productModel->getProductById($product_id);
            if (!$product || $product['stock'] < $qty) {
                echo "在庫不足のため購入できません";
                return;
            }
            $product['quantity'] = $qty;
            $items[] = $product;
        }

        $order_id = $this->orderModel->create($user_id, $items);
        Cart::clear();

        echo $this->render('checkout/complete.twig', ['order_id' => $order_id]);
    }
}
