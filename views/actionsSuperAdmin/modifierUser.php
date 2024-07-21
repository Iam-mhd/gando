<?php

require_once '../../_config/db.php';
require_once '../../models/usermodel.php';
require_once '../../controllers/usercontroller.php';

// Initialiser la base de données et les contrôleurs
$userModel = new UserModel($database);
$userController = new UserController($userModel);

$user = null; // Initialiser la variable $user pour stocker les informations de l'utilisateur
$message = '';
$messageType = ''; // "success" ou "error"

// Traitement de la recherche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchId = filter_var($_POST['search_id'], FILTER_SANITIZE_NUMBER_INT);
    $searchNom = filter_var($_POST['search_nom'], FILTER_SANITIZE_STRING);

    if (!empty($searchId) && !empty($searchNom)) {
        // Rechercher l'utilisateur par ID
        $user = $userModel->getUserById($searchId);
        
        // Vérifier si le nom correspond
        if ($user && $user['nom'] === $searchNom) {
            $message = "Utilisateur trouvé. Vous pouvez maintenant modifier ses informations.";
            $messageType = "success";
        } else {
            $user = null;
            $message = "Aucun utilisateur trouvé avec ces informations.";
            $messageType = "error";
        }
    } else {
        $message = "Veuillez entrer l'ID et le nom de l'utilisateur.";
        $messageType = "error";
    }
}

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (
        isset($_POST['id_user'], $_POST['prenom'], $_POST['nom'], $_POST['telephone'], $_POST['email']) &&
        !empty($_POST['id_user']) && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['telephone']) && !empty($_POST['email'])
    ) {
        $id = filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT);
        $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
        $telephone = filter_var($_POST['telephone'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data = [
                'prenom' => $prenom,
                'nom' => $nom,
                'telephone' => $telephone,
                'email' => $email
            ];

            if ($userController->updateUser($id, $data)) {
                $message = "L'utilisateur a été mis à jour avec succès.";
                $messageType = "success";
                // Après une mise à jour réussie, nous recherchons à nouveau les informations pour les afficher
                $user = $userModel->getUserById($id);
            } else {
                $message = "Erreur lors de la mise à jour de l'utilisateur.";
                $messageType = "error";
            }
        } else {
            $message = "Adresse e-mail invalide.";
            $messageType = "error";
        }
    } else {
        $message = "Tous les champs sont obligatoires.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche et Modification Utilisateur</title>
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

        input[type="text"],
        input[type="email"] {
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

        /* Styles pour la fenêtre modale */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Recherche Utilisateur</h1>
    <form action="" method="POST">
        <label for="search_id">ID Utilisateur:</label>
        <input type="text" id="search_id" name="search_id" required>
        
        <label for="search_nom">Nom:</label>
        <input type="text" id="search_nom" name="search_nom" required>
        
        <button type="submit" name="search">Rechercher</button>
        <button class="back-button" onclick="history.back()">Retour</button>
    </form>

    <?php if (isset($message)): ?>
        <p class="message <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Fenêtre modale -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Modifier Utilisateur</h1>
            <form action="" method="POST">
                <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($user['id_user']); ?>">

                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>

                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>

                <label for="telephone">Téléphone:</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <button type="submit" name="update">Mettre à jour</button>
            </form>
        </div>
    </div>

    <script>
        // Obtenez la modal
        var modal = document.getElementById("userModal");

        // Obtenez le bouton pour fermer la modal
        var span = document.getElementsByClassName("close")[0];

        // Fonction pour afficher la modal après la recherche réussie
        function showModal() {
            modal.style.display = "block";
        }

        // Lorsque l'utilisateur clique sur <span> (x), fermer la modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Lorsque l'utilisateur clique en dehors de la modal, fermer la modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Afficher la modal si l'utilisateur est trouvé
        <?php if ($user): ?>
            showModal();
        <?php endif; ?>
    </script>
</body>
</html>