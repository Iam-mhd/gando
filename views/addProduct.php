<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ffecd2, #fcb69f);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            animation: fadeIn 1s ease-in-out;
            margin-bottom: 20px;
        }

        form label {
            color: #333;
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
        }

        form input, form textarea, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        form input:focus, form textarea:focus, form select:focus {
            border-color: #fcb69f;
            box-shadow: 0 0 8px rgba(252, 182, 159, 0.3);
        }

        form button {
            background: linear-gradient(to right, #ff6a6a, #fcb69f);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: linear-gradient(to right, #fcb69f, #ff6a6a);
        }

        .back-button {
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background: linear-gradient(to right, #0056b3, #0084ff);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="back-button" onclick="history.back()">Retour</button>
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="createProduct">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="price">Prix:</label>
            <input type="number" step="0.01" id="price" name="price" required>
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>
            <label for="image_url">URL de l'image:</label>
            <input type="url" id="image_url" name="image_url" required>
            <label for="category_id">Catégorie:</label>
            <select id="category_id" name="category_id" required>
                <option value="1">Sandales Traditionnelles</option>
                <option value="2">Bottes en Cuir</option>
                <option value="3">Chaussures de Mariage</option>
                <option value="4">Ballerines Africaines</option>
                <option value="5">Chaussures en Tissu Wax</option>
                <option value="6">Espadrilles Africaines</option>
                <option value="7">Mocassins Traditionnels</option>
                <option value="8">Chaussures de Travail en Cuir</option>
                <option value="9">Sandales en Perles</option>
                <option value="10">Babouches Africaines</option>
                <option value="11">Chaussures pour Enfants</option>
                <option value="12">Chaussures de Sport</option>
            </select>
            <button type="submit">Ajouter Produit</button>
        </form>
    </div>
</body>
</html>
