<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Order;

class AdminOrderController extends BaseController
{
    private Order $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
    }

    public function index()
    {
        if (!isAdmin()) {
            http_response_code(403);
            echo "管理者のみ閲覧可能です。";
            return;
        }

        $orders = $this->orderModel->getAllOrders();
        echo $this->render('admin/orders/index.twig', ['orders' => $orders]);
    }

    public function detail(int $order_id)
    {
        if (!isAdmin()) {
            http_response_code(403);
            echo "管理者のみ閲覧可能です。";
            return;
        }

        $items = $this->orderModel->getOrderItems($order_id);
        echo $this->render('admin/orders/detail.twig', [
            'order_id' => $order_id,
            'items' => $items
        ]);
    }
}
