<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Order;

class MypageController extends BaseController
{
    private Order $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
    }

    public function index()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            header('Location: /login');
            exit;
        }

        $orders = $this->orderModel->getOrdersByUserId($user_id);

        echo $this->render('mypage/index.twig', ['orders' => $orders]);
    }

    public function detail(int $order_id)
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            header('Location: /login');
            exit;
        }

        // 注文の所有者確認（セキュリティ）
        $orders = $this->orderModel->getOrdersByUserId($user_id);
        $order_ids = array_column($orders, 'id');

        if (!in_array($order_id, $order_ids)) {
            http_response_code(403);
            echo "アクセス拒否";
            return;
        }

        $items = $this->orderModel->getOrderItems($order_id);
        echo $this->render('mypage/detail.twig', [
            'order_id' => $order_id,
            'items' => $items
        ]);
    }
}
