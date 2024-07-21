<?php
// Inclusion du fichier de connexion
require_once __DIR__ . '/../../_config/db.php';

try {
    // Vérifiez le nombre de clients
    $stmt = $database->prepare("SELECT COUNT(*) AS count FROM clients");
    $stmt->execute();
    $clientCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Vérifiez le nombre de produits
    $stmt = $database->prepare("SELECT COUNT(*) AS count FROM produits");
    $stmt->execute();
    $productCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Vérifiez le nombre d'admins
    $stmt = $database->prepare("SELECT COUNT(*) AS count FROM users");
    $stmt->execute();
    $adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Vérifiez le nombre de stocks (définit la variable $totalStock si besoin)
    $stmt = $database->prepare("SELECT SUM(stock) AS total_stock FROM produits");
    $stmt->execute();
    $totalStock = $stmt->fetch(PDO::FETCH_ASSOC)['total_stock'];

    // Vérifiez le nombre total de commandes
    $stmt = $database->prepare("SELECT COUNT(*) AS total_commandes FROM commandes");
    $stmt->execute();
    $totalCommandes = $stmt->fetch(PDO::FETCH_ASSOC)['total_commandes'];

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="./public/style.css"> <!-- Assurez-vous que le chemin est correct -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 20%;
            background-color: #007bff;
            padding: 20px;
            color: #fff;
            position: relative;
        }

        .sidebar img.logo {
            max-width: 150px; /* Ajustez la taille du logo selon vos besoins */
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        
        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            background-color: #0056b3;
            padding: 10px;
            border-radius: 5px;
            display: block;
            font-weight: bold;
        }

        .sidebar ul li a:hover {
            background-color: #004494;
        }
        .sidebar img.logo {
    max-width: 200px; /* Ajustez la largeur maximale du logo */
    height: auto; /* Conserve les proportions du logo */
    margin-bottom: 40px; /* Espacement sous le logo */
    border-radius: 30%; /* Rend l'image circulaire */
    object-fit: cover; /* Couvre toute la zone, coupe si nécessaire */
}

        .main {
            width: 80%;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ccc;
            padding: 10px;
            border-radius: 10px;
        }

        .header input[type="text"] {
            width: 60%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .header .emoji {
            font-size: 1.5em;
        }

        .header .user-name {
            margin-right: 10px;
        }

        .header .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .content {
            margin-top: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: repeat(3, auto);
            gap: 20px;
        }

        .box {
            background-color: #fff;
            padding: 50px;
            border-radius: 15px;
            border: 1px solid #ccc;
            position: relative;
        }

        .oval {
            border-radius: 40px;
        }

        .footer {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }

        .back-button {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script>
        function toggleHistorique() {
            var tableContainer = document.getElementById('table-container');
            if (tableContainer.style.display === "none") {
                tableContainer.style.display = "block";
            } else {
                tableContainer.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
        <img src="../../public/logo/logo.jpg" alt="Logo" class="logo">

            <ul>
                <li><a href="../listProduits.php">Gestion des produits</a></li>
                <li><a href="../addProduct.php">Ajouter des produits</a></li>
                <li><a href="gestion_commandes.php">Gestion des commandes</a></li>
                <li><a href="../userview.php">Liste des utilisateurs</a></li>
                <li><a href="modifierUser.php">Modifier l'Administrateur</a></li>
                <li><a href="supprimerUser.php">Supprimer l'Administrateur</a></li>
                <li><a href="../deconnexion.php">Déconnexion</a></li>
            </ul>
        </div>
        <div class="main">
            <h2>Tableau de bord du super administrateur</h2>
            <div class="header">
                <form action="../recherche.php" method="get">
                    <input type="text" name="query" placeholder="Rechercher des produits...">
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            <div class="content">
                <div class="box oval">
                    <h3>Nombres de clients</h3>
                    <p><?php echo htmlspecialchars($clientCount); ?></p>
                </div>
                <div class="box oval">
                    <h3>Nombres de produits</h3>
                    <p><?php echo htmlspecialchars($productCount); ?></p>
                </div>
                <div class="box oval">
                    <h3>Nombres d'admins</h3>
                    <p><?php echo htmlspecialchars($adminCount); ?></p>
                </div>
                <div class="box oval">
                    <h3>Nombres de stocks</h3>
                    <p><?php echo htmlspecialchars($totalStock); ?></p>
                </div>
                <div class="box oval">
                    <h3>Évolution des commandes</h3>
                    <!-- Contenu provenant de la base de données -->
                </div>
                <div class="box oval">
                    <h3>Nombre total de commandes</h3>
                    <p><?php echo htmlspecialchars($totalCommandes); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        &copy; 2024 Société Bah & Frères. Tous droits réservés.
    </div>
</body>
</html>
