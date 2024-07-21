<?php
require_once '../_config/db.php';
require_once '../models/productmodel.php';
require_once '../controllers/productcontroller.php';

session_start();

$productModel = new ProductModel($database);
$productController = new ProductController($productModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $productId = $_POST['product_id'] ?? null;

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'image_url' => $_POST['image_url'],
            'category_id' => $_POST['category_id']
        ];

        switch ($action) {
            case 'add':
                $productController->createProduct($data);
                break;
            case 'update':
                $productController->updateProduct($productId, $data);
                break;
            case 'delete':
                $productController->deleteProduct($productId);
                break;
        }
    }
    header('Location: listProduits.php');
    exit;
}

$products = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            padding: 20px 0;
        }
        .products {
            max-width: 1000px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .product {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .product:last-child {
            border-bottom: none;
        }
        .product img {
            max-width: 50px;
            border-radius: 5px;
        }
        .product-info {
            display: flex;
            flex-direction: column;
            width: 200px;
        }
        .product form {
            display: flex;
            flex-direction: column;
        }
        .product button {
            margin-top: 5px;
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .product button:hover {
            background-color: #218838;
        }
        .product .delete-button {
            background-color: #dc3545;
        }
        .product .delete-button:hover {
            background-color: #c82333;
        }
        .add-product {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        .add-product input {
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .back-button {
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: flex-start;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .back-button-container {
            display: flex;
            justify-content: flex-start;
        }
    </style>
</head>
<body>
    <h1>Gestion des Produits</h1>
    <div class="products">
        <div class="back-button-container">
            <button class="back-button" onclick="history.back()">Retour</button>
        </div>
        <div class="add-product">
            <a href="addProduct.php"><button type="submit">Ajouter Un nouveau Produit</button></a>
        </div>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <div class="product-info">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <span><?php echo htmlspecialchars($product['name']); ?></span>
                        <span><?php echo htmlspecialchars($product['description']); ?></span>
                        <span>Prix: <?php echo htmlspecialchars($product['price']); ?> FCFA</span>
                        <span>Stock: <?php echo htmlspecialchars($product['stock']); ?></span>
                        <span>Catégorie: <?php echo htmlspecialchars($product['category_id']); ?></span>
                    </div>
                    <form action="listProduits.php" method="POST">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        <input type="text" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" required>
                        <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                        <input type="text" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" required>
                        <input type="number" name="category_id" value="<?php echo htmlspecialchars($product['category_id']); ?>" required>
                        <button type="submit">Mettre à jour</button>
                    </form>
                    <form action="listProduits.php" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="delete-button">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit trouvé</p>
        <?php endif; ?>
    </div>
</body>
</html>
