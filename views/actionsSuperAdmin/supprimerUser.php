<?php

require_once '../../_config/db.php';
require_once '../../models/usermodel.php';
require_once '../../controllers/usercontroller.php';

// Initialiser la base de données et les contrôleurs
$userModel = new UserModel($database);
$userController = new UserController($userModel);

$message = '';
$messageType = ''; // "success" ou "error"

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id)) {
        if ($userController->deleteUserById($id)) {
            $message = "L'utilisateur a été supprimé avec succès.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de la suppression de l'utilisateur.";
            $messageType = "error";
        }
    } else {
        $message = "ID utilisateur invalide.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #0044cc;
            text-align: center;
            background-color: #fff;
            padding: 20px;
            margin: 0;
            border-bottom: 2px solid #0044cc;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            background-color: #0044cc;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0033aa;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button-container button {
            flex: 1;
            margin: 0 5px;
        }

        .back-button {
            background-color: #ccc;
            color: #333;
        }

        .back-button:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body>
    <h1>Supprimer Utilisateur</h1>
    <form action="" method="POST">
        <label for="id_user">ID Utilisateur à supprimer:</label>
        <input type="text" id="id_user" name="id_user" required>
        
        <div class="button-container">
            <button type="submit" name="delete">Supprimer</button>
            <button class="back-button" onclick="history.back()">Retour</button>
        </div>
    </form>

    <?php if (isset($message)): ?>
        <p class="message <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>
