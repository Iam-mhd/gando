<?php
// Importer les dépendances
require_once '_config/db.php';
require_once 'models/usermodel.php';
require_once 'controllers/usercontroller.php';
require_once 'models/productModel.php';
require_once 'controllers/productController.php';
require_once 'models/categoriModel.php'; // Nouveau
require_once 'controllers/categoriController.php'; // Nouveau

// Démarrer la session
session_start();

// Gestion des connexions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification pour les utilisateurs
    $tableUser = "SELECT * FROM users WHERE email = :email AND mot_de_passe = :password";
    $requete = $database->prepare($tableUser);
    $requete->bindParam(':email', $email);
    $requete->bindParam(':password', $password);
    $requete->execute();
    $user = $requete->fetch();

    if ($user) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['email'] = $user['email'];
        header('Location: index.php');
        exit;
    } else {
        // Vérification pour les super utilisateurs
        $tableSuperUser = "SELECT * FROM superUser WHERE email = :email AND mot_de_passe = :password";
        $requete = $database->prepare($tableSuperUser);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':password', $password);
        $requete->execute();
        $superUser = $requete->fetch();

        if ($superUser) {
            $_SESSION['id_superUser'] = $superUser['id_superUser'];
            $_SESSION['email'] = $superUser['email'];
            header('Location: index.php'); 
            exit;
        } else {
            $message = "Adresse e-mail ou mot de passe incorrect.";
        }
    }
}

// Gestion de l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $productId = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Ajouter le produit au panier
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }

    header('Location: index.php');
    exit;
}

// Inclure l'en-tête approprié en fonction du type d'utilisateur
if (isset($_SESSION['id_superUser'])) {
    require_once 'views/includes/headerSuperAdmin.php';
} elseif (isset($_SESSION['id_user'])) {
    require_once 'views/includes/headerAdmin.php';
} else {
    require_once 'views/includes/headerUser.php';
}

// Initialiser le modèle et le contrôleur pour les utilisateurs
$userModel = new UserModel($database);
$userController = new UserController($userModel);

// Vérifier l'action demandée
if (isset($_GET['action']) && $_GET['action'] === 'manageUsers') {
    $userController->showAllUsers();
    exit; // Sortir pour éviter d'afficher le reste de la page
}



// Initialiser le modèle et le contrôleur pour les catégories
$categoryModel = new CategoryModel($database);
$categoryController = new CategoryController($categoryModel);
$categories = $categoryModel->getAllCategories(); // Obtenir toutes les catégories



?>
<!DOCTYPE html>
<html>
<head>
    <title>Page d'accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #333;
            padding: 20px 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            gap: 20px;
        }

        .product-view {
            flex: 3;
        }

        .category-view {
            width: 250px;
            border-right: 1px solid #ccc;
            padding-right: 20px;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 200px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product img {
            max-width: 100%;
            border-radius: 10px;
        }

        .product h2 {
            color: #333;
            font-size: 1.2em;
            margin: 10px 0;
        }

        .product p {
            color: #666;
            margin: 5px 0;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .product button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product button:hover {
            background-color: #218838;
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination-link {
            display: inline-block;
            margin: 0 5px;
            padding: 10px 15px;
            color: #333;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination-link:hover {
            background-color: #333;
            color: white;
        }

        .category-view ul {
            list-style-type: none;
            padding: 0;
        }

        .category-view li {
            margin: 10px 0;
        }

        .category-view a {
            color: #007bff;
            text-decoration: none;
        }

        .category-view a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="category-view">
            <?php include 'views/categoriview.php'; ?>
            
        </div>
        <div class="product-view">
            <?php 
            // Initialiser le modèle et le contrôleur pour les produits
            $productModel = new ProductModel($database);
            $productController = new ProductController($productModel);
            $productController->showAllProducts();
            ?>
            
        </div>
    </div>
</body>
</html>





