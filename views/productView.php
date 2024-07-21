<!DOCTYPE html>
<html>
<head>
    <title>Tous Les Produits</title>
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
        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
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
    </style>
</head>
<body>
    <h1>Bah & Frères</h1>
    <?php if (!empty($products)): ?>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>Prix: <?php echo htmlspecialchars($product['price']); ?> FCFA</p>
                    <p>Stock: <?php echo htmlspecialchars($product['stock']); ?></p>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit">Ajouter au panier</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="pagination-link"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <p>Aucun produit trouvé</p>
    <?php endif; ?>
</body>
</html>
