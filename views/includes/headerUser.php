
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Header Client</title>
   <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="./views/actionsClients/panier.php">Panier</a></li>
            </ul>
            <ul>
                <li>
                    <div class="search-container">
                    <form action="./views/recherche_client.php" method="get">
                 <input type="text" name="query" placeholder="Rechercher des produits...">
                <button type="submit">Rechercher</button>
            </form>
                    </div>
                </li>
                <li>
                    <a href="./views/connexion.php">
                        <img src="public/assets/img/icones/avatar-de-connexion.png" alt="Connexion" class="icon">
                        Connexion
                    </a>
                </li>
            </ul>
        </nav>
    </header>
</body>
</html>
