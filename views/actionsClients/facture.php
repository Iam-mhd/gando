<?php
require_once '../../_config/db.php';
require_once '../../models/clientmodel.php';
require_once '../../controllers/clientcontroller.php';
require_once '../../models/productmodel.php';
require_once '../../controllers/productcontroller.php';

session_start();

$clientModel = new ClientModel($database);
$clientController = new ClientController($clientModel, $database);
$productModel = new ProductModel($database);
$productController = new ProductController($productModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $clientController->handleClient($_POST);

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

    $commandeId = $clientController->handleCommande($clientId, $totalPrice);

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Facture Proforma</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f8f8;
                margin: 0;
                padding: 20px;
            }
            .invoice {
                max-width: 800px;
                margin: auto;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .invoice h1 {
                text-align: center;
                color: #333;
            }
            .client-info, .product-info {
                margin-bottom: 20px;
            }
            .product-info table {
                width: 100%;
                border-collapse: collapse;
            }
            .product-info table, .product-info th, .product-info td {
                border: 1px solid #ddd;
            }
            .product-info th, .product-info td {
                padding: 10px;
                text-align: left;
            }
            .total {
                text-align: right;
                font-size: 1.2em;
                color: #333;
            }
        </style>
    </head>
    <body>
        <div class="invoice">
            <h1>Facture Proforma</h1>
            <div class="client-info">
                <h2>Informations du Client</h2>
                <p>ID Client: <?php echo $clientId; ?></p>
                <p>Nom: <?php echo htmlspecialchars($_POST['nom']); ?></p>
                <p>Prénom: <?php echo htmlspecialchars($_POST['prenom']); ?></p>
                <p>Adresse: <?php echo htmlspecialchars($_POST['adresse']); ?></p>
                <p>Téléphone: <?php echo htmlspecialchars($_POST['telephone']); ?></p>
                <p>Email: <?php echo htmlspecialchars($_POST['email']); ?></p>
            </div>
            <div class="product-info">
                <h2>Détails des Produits</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productsInCart as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['price']); ?> FCFA</td>
                                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($product['total_price']); ?> FCFA</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="total">
                <p>Total à payer: <?php echo $totalPrice; ?> FCFA</p>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    header("Location: panier.php");
    exit;
}
?>
