<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Product;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }

    public function list(): void
    {
        $products = $this->productModel->getAllProducts();
        echo $this->render('product/list.twig', ['products' => $products]);
    }

    public function detail(int $id): void
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "商品が見つかりません。";
            return;
        }
        echo $this->render('product/detail.twig', ['product' => $product]);
    }
}