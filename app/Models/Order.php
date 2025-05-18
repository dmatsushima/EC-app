<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Order
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function create(int $user_id, array $items): int
    {
        $this->pdo->beginTransaction();

        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 注文作成
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
        $stmt->execute([$user_id, $total]);
        $order_id = (int)$this->pdo->lastInsertId();

        // 注文明細
        $item_stmt = $this->pdo->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)"
        );

        foreach ($items as $item) {
            $item_stmt->execute([
                $order_id,
                $item['id'],
                $item['quantity'],
                $item['price']
            ]);

            // 在庫を減らす
            $this->pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?")
                      ->execute([$item['quantity'], $item['id']]);
        }

        $this->pdo->commit();

        return $order_id;
    }
}
