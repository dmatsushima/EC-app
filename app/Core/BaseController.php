<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, [
            'cache' => false, // 開発中はfalse、本番は'dir/cache'
            'autoescape' => 'html',
        ]);
    }
    /**
     * Twigテンプレートをレンダリングする
     *
     * @param string $template テンプレートパス（例: 'user/login.twig'）
     * @param array $params テンプレートに渡す変数
     * @return string
     */
    protected function render(string $template, array $params = []): string
    {
        return $this->twig->render($template, $params);
    }
}