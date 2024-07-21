<?php
// Inclusion du fichier de connexion
require_once '../_config/db.php';

// Vérifiez si la connexion est définie
if (!isset($database)) {
    die("Erreur : Connexion n'est pas définie.");
}

// Recherche des produits
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Préparation de la requête pour rechercher des produits
    $sql = "SELECT DISTINCT * FROM produits WHERE name LIKE :searchTerm";
    $stmt = $database->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    
    // Affichage des résultats
    echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Recherche</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header input[type="text"] {
            width: 50%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #e1e4e8;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: calc(33.333% - 20px);
            box-sizing: border-box;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .product h3 {
            margin-top: 0;
            color: #333;
            font-size: 20px;
        }
        .product p {
            margin: 10px 0;
            line-height: 1.6;
        }
        .product p strong {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Résultats de la Recherche</h1>
        </div>
        <div class="product-list">';
    
    // Assurez-vous que la boucle affiche une seule fois les résultats
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="product">';
        echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
        echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
        echo '<p><strong>Prix:</strong> ' . htmlspecialchars($row['price']) . ' €</p>';
      
        // Vérifiez que la colonne 'category' existe dans votre base de données
        if (isset($row['category'])) {
            echo '<p><strong>Catégorie:</strong> ' . htmlspecialchars($row['category']) . '</p>';
        }
        echo '</div>';
    }
    
    echo '</div>
    </div>
</body>
</html>';
} else {
    echo "<p>Aucune recherche effectuée.</p>";
}
?>
