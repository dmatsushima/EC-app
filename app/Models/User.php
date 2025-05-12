<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    /**
     * メールアドレスからユーザーを検索する
     */
    public function findByEmail(string $email): ?array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * 新しいユーザーを登録する
     */
    public function create(string $name, string $email, string $passwordHash): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $passwordHash]);
    }

    /**
     * IDからユーザー情報を取得（任意機能）
     */
    public function findById(int $id): ?array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
