<?php

class CategoryController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function showCategories() {
        $categories = $this->model->getAllCategories();
        include './views/categoriView.php';
    }

    public function showProductsByCategory($id) {
        $products = $this->model->getProductsByCategoryId($id);
        include './views/listProduits.php';
    }
}
