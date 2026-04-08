<?php
session_start();
require 'config.php';
$db = getDBConnection();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Produit non trouvé.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
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
        <div class="product-detail">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p>Prix: <?php echo $product['price']; ?> €</p>
            <p>Stock: <?php echo $product['stock']; ?></p>
            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>