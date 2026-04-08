<?php
session_start();
require 'config.php';
$db = getDBConnection();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$session_id = session_id();

$query = "SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE ";
if ($user_id) {
    $query .= "c.user_id = ?";
    $params = [$user_id];
} else {
    $query .= "c.session_id = ?";
    $params = [$session_id];
}

$stmt = $db->prepare($query);
$stmt->execute($params);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
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
        <h2>Votre Panier</h2>
        <?php if (empty($cart_items)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['price']; ?> €</td>
                            <td><?php echo $item['price'] * $item['quantity']; ?> €</td>
                            <td><a href="remove_from_cart.php?id=<?php echo $item['id']; ?>">Retirer</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total: <?php echo $total; ?> €</p>
            <a href="checkout.php">Commander</a>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2023 Mon E-commerce</p>
    </footer>
</body>
</html>