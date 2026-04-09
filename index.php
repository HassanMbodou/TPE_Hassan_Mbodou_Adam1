<?php
/**
 * PROJET TPE - Site E-commerce Dynamique
 * 
 * Auteur : Hassan Mbodou Adam
 * Matricule : 23A624FS
 * Année : 2023-2024
 * 
 * Page d'accueil - Affichage du catalogue de produits
 */

session_start();
require 'config.php';
$db = getDBConnection();

$stmt = $db->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Site E-commerce</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Mon E-commerce</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="cart.php">Panier</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="login.php">Connexion</a>
                <a href="register.php">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <h2>Produits</h2>
        <div class="products">
            <?php foreach($products as $product): ?>
                <?php $productImage = !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/400x250?text=Produit';
                $ratingInfo = getProductRating($db, $product['id']); ?>
                <div class="product">
                    <img class="product-image" src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="product-meta">
                        <span class="product-price"><?php echo $product['price']; ?> €</span>
                        <span class="product-rating">Note : <?php echo $ratingInfo['avg_rating'] > 0 ? number_format($ratingInfo['avg_rating'], 1) : 'N/A'; ?> / 5</span>
                    </div>
                    <p class="review-count"><?php echo $ratingInfo['review_count']; ?> avis</p>
                    <a class="button" href="product.php?id=<?php echo $product['id']; ?>">Voir détails</a>
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit">Ajouter au panier</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>