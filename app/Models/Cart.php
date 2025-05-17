<?php

namespace App\Models;

class Cart
{
    public static function getItems(): array
    {
        return $_SESSION['cart'] ?? [];
    }

    public static function addItem(int $product_id, int $quantity = 1): void
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }

    public static function removeItem(int $product_id): void
    {
        unset($_SESSION['cart'][$product_id]);
    }

    public static function clear(): void
    {
        unset($_SESSION['cart']);
    }
}
