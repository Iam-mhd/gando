<?php

require_once '../../_config/db.php';
require_once '../../models/commandemodel.php';
require_once '../../controllers/commandecontroller.php';

session_start();

// Initialisation du modèle et du contrôleur
$commandeModel = new CommandeModel($database); // Assure-toi que $database est bien ta connexion PDO
$commandeController = new CommandeController($commandeModel);

// Récupération des commandes en attente avec les informations clients
$commandesEnAttente = $commandeModel->getCommandesEnAttente();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Commandes</title>
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
        .orders {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .order-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item h2 {
            color: #333;
            font-size: 1em;
            margin: 0;
        }
        .order-item p {
            color: #666;
            margin: 5px 0;
        }
        .order-item form {
            text-align: right;
        }
        .order-item button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .order-item button:hover {
            background-color: #218838;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Gestion des Commandes</h1>
    <button class="back-button" onclick="history.back()">Retour</button>
    
    <div class="orders">
        <?php if (!empty($commandesEnAttente)): ?>
            <?php foreach ($commandesEnAttente as $commande): ?>
                <div class="order-item">
                    <h2>Commande ID: <?php echo htmlspecialchars($commande['id_commande']); ?></h2>
                    <?php if (isset($commande['nom'])): ?>
                    <?php endif; ?>
                    <p>Total: <?php echo htmlspecialchars($commande['total_price']); ?> FCFA</p>
                    <form action="gestion_commandes.php" method="POST">
                        <input type="hidden" name="commande_id" value="<?php echo $commande['id_commande']; ?>">
                        <button type="submit">Valider la commande</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune commande en attente.</p>
        <?php endif; ?>
    </div>
</body>
</html>
