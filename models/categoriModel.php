<?php

class CategoryModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllCategories() {
        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategoryId($categoryId) {
        $query = $this->db->prepare("SELECT * FROM produits WHERE category_id = :category_id");
        $query->bindParam(':category_id', $categoryId);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
