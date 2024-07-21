<?php
class ProductModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getProductById($id) {
        $query = $this->db->prepare("SELECT * FROM produits WHERE id = :id");
        $query->execute([':id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllProducts($limit, $offset) {
        $query = $this->db->prepare("SELECT * FROM produits LIMIT :limit OFFSET :offset");
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countProducts() {
        $query = $this->db->prepare("SELECT COUNT(*) as count FROM produits");
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function createProduct($data) {
        $query = $this->db->prepare("INSERT INTO produits (name, description, price, stock, image_url, category_id) VALUES (:name, :description, :price, :stock, :image_url, :category_id)");
        return $query->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':stock' => $data['stock'],
            ':image_url' => $data['image_url'],
            ':category_id' => $data['category_id']
        ]);
    }

    public function updateProduct($id, $data) {
        $query = $this->db->prepare("UPDATE produits SET name = :name, description = :description, price = :price, stock = :stock, image_url = :image_url, category_id = :category_id WHERE id = :id");
        return $query->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':stock' => $data['stock'],
            ':image_url' => $data['image_url'],
            ':category_id' => $data['category_id']
        ]);
    }

    public function deleteProduct($id) {
        $query = $this->db->prepare("DELETE FROM produits WHERE id = :id");
        return $query->execute([':id' => $id]);
    }
}
?>
