<?php
require_once 'C:/xampp/htdocs/bassekou/MVC1/_config/db.php'; // Assurez-vous que le chemin est correct
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../listProduits.php");
    exit();
}

// Connexion à la base de données
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

$sql = "SELECT * FROM produits WHERE nom LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%{$query}%";
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
$produits = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Recherche</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="../listProduits.php">Liste des produits</a></li>
                <li><a href="../userview.php">Liste des utilisateurs</a></li>
                <li><a href="../addProduct.php">Ajouter des produits</a></li>
                <li><a href="../deconnexion.php">Déconnexion</a></li>
            </ul>
        </div>
        <div class="main">
            <h2>Résultats de la recherche pour "<?php echo htmlspecialchars($query); ?>"</h2>
            <div class="content">
                <?php if (empty($produits)) : ?>
                    <p>Aucun produit trouvé.</p>
                <?php else : ?>
                    <ul>
                        <?php foreach ($produits as $produit) : ?>
                            <li><?php echo htmlspecialchars($produit['nom']); ?> - <?php echo htmlspecialchars($produit['prix']); ?> €</li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer">
        &copy; 2024 Société Bah & Frères. Tous droits réservés.
    </div>
</body>
</html>
