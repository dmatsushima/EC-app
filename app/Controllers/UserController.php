<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\BaseController;

class UserController extends BaseController
{
    // 会員登録
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors   = [];

            // バリデーション
            if ($name === '' || $email === '' || $password === '') {
                $errors[] = 'すべての項目を入力してください。';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'メールアドレスの形式が正しくありません。';
            }

            // 重複チェック
            $userModel = new User();
            if ($userModel->findByEmail($email)) {
                $errors[] = 'このメールアドレスはすでに登録されています。';
            }

            if (empty($errors)) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $userModel->create($name, $email, $passwordHash);
                header('Location: /login');
                exit;
            }

            // エラー表示
            echo $this->render('user/register.twig', [
                'errors' => $errors,
                'name' => $name,
                'email' => $email
            ]);
        } else {
            echo $this->render('user/register.twig');
        }
    }

    // ログイン
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $error    = null;

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['is_admin']  = $user['is_admin'];
                header('Location: /');
                exit;
            } else {
                $error = 'メールアドレスまたはパスワードが正しくありません。';
            }

            echo $this->render('user/login.twig', [
                'error' => $error,
                'email' => $email
            ]);
        } else {
            echo $this->render('user/login.twig');
        }
    }

    // ログアウト
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }

    // ログインフォーム表示
    public function showLoginForm(): string
    {
        $email = $_POST['email'] ?? '';
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);

        return $this->render('user/login.twig', [
            'email' => $email,
            'error' => $error
        ]);
    }

    // 登録フォーム表示
    public function showRegisterForm(): string
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $errors = $_SESSION['register_errors'] ?? null;
        unset($_SESSION['register_errors']);

        return $this->render('user/register.twig', [
            'name' => $name,
            'email' => $email,
            'errors' => $errors
        ]);
    }

}
