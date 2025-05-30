<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;

    public static function getInstance(): PDO
    {
        if (!self::$instance) {
            try {
                $dsn = "mysql:host=localhost;dbname=ec_db;charset=utf8mb4";
                $user = "ec_user";
                $pass = "ec_pass";
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                die("DB接続エラー: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
