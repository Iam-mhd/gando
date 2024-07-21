<?php
require_once '../../_config/db.php';
require_once '../../models/productmodel.php';
require_once '../../controllers/productcontroller.php';

session_start();

$productModel = new ProductModel($database);
$productController = new ProductController($productModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $productId = $_POST['product_id'];

        if ($_POST['action'] === 'increase') {
            $_SESSION['cart'][$productId]++;
        } elseif ($_POST['action'] === 'decrease') {
            $_SESSION['cart'][$productId]--;
            if ($_SESSION['cart'][$productId] < 1) {
                unset($_SESSION['cart'][$productId]);
            }
        }
    }
}

$productsInCart = [];
$totalPrice = 0;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $product = $productModel->getProductById($productId);
        if ($product) {
            $product['quantity'] = $quantity;
            $product['total_price'] = $product['price'] * $quantity;
            $totalPrice += $product['total_price'];
            $productsInCart[] = $product;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panier</title>
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
        .cart {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item img {
            max-width: 80px;
            border-radius: 10px;
        }
        .cart-item h2 {
            color: #333;
            font-size: 1em;
            margin: 0;
        }
        .cart-item p {
            color: #666;
            margin: 5px 0;
        }
        .cart-item .quantity {
            display: flex;
            align-items: center;
        }
        .cart-item .quantity button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
            transition: background-color 0.3s;
        }
        .cart-item .quantity button:hover {
            background-color: #218838;
        }
        .total-price {
            text-align: right;
            padding: 20px 0;
            font-size: 1.2em;
            color: #333;
        }
        .user-info {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .user-info label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .user-info input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .validate-button {
            text-align: center;
            margin-top: 20px;
        }
        .validate-button button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .validate-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Votre Panier</h1>
    <div class="cart">
        <?php if (!empty($productsInCart)): ?>
            <?php foreach ($productsInCart as $product): ?>
                <div class="cart-item">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div>
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                        <p>Prix: <?php echo htmlspecialchars($product['price']); ?> FCFA</p>
                        <p>Total: <?php echo htmlspecialchars($product['total_price']); ?> FCFA</p>
                    </div>
                    <div class="quantity">
                        <form action="panier.php" method="POST">
                            <input type="hidden" name="action" value="decrease">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit">-</button>
                        </form>
                        <p><?php echo htmlspecialchars($product['quantity']); ?></p>
                        <form action="panier.php" method="POST">
                            <input type="hidden" name="action" value="increase">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit">+</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="total-price">
                <p>Total à payer: <?php echo htmlspecialchars($totalPrice); ?> FCFA</p>
            </div>
            <div class="user-info">
                <form action="facture.php" method="POST">
                    <label for="prenom">Prénom:</label>
                    <input type="text" id="prenom" name="prenom" required>
                    
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" required>
                    
                    <label for="adresse">Adresse:</label>
                    <input type="text" id="adresse" name="adresse" required>
                    
                    <label for="telephone">Téléphone:</label>
                    <input type="text" id="telephone" name="telephone" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="sexe">Sexe:</label>
                    <select id="sexe" name="sexe" required>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                    
                    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($totalPrice); ?>">
                    
                    <div class="validate-button">
                        <button type="submit">Valider le panier</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </div>
</body>
</html>
