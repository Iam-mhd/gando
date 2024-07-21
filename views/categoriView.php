<!DOCTYPE html>
<html>
<head>
    <title>Catégories</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Catégories</h2>
    <ul>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <li>
                    <a href="index.php?action=viewProducts&category_id=<?php echo htmlspecialchars($category['id']); ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Aucune catégorie trouvée</li>
        <?php endif; ?>
    </ul>
</body>
</html>
