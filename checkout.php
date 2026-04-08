<?php
session_start();
require 'config.php';
$db = getDBConnection();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$session_id = session_id();

$query = "SELECT c.*, p.name, p.price, p.stock FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Créer la commande
    $stmt = $db->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    $order_id = $db->lastInsertId();

    // Ajouter les items
    foreach ($cart_items as $item) {
        $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);

        // Mettre à jour le stock
        $new_stock = $item['stock'] - $item['quantity'];
        $stmt = $db->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->execute([$new_stock, $item['product_id']]);
    }

    // Vider le panier
    $stmt = $db->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);

    echo "Commande passée avec succès!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Mon E-commerce</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="cart.php">Panier</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <h2>Finaliser la commande</h2>
        <p>Total: <?php echo $total; ?> €</p>
        <form method="post">
            <button type="submit">Confirmer la commande</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>