<?php
session_start();
require '../config.php';
$db = getDBConnection();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Simple check if admin (for demo, assume user_id 1 is admin)
if ($_SESSION['user_id'] != 1) {
    echo "Accès refusé.";
    exit;
}

$products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
$orders = $db->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Panel Admin</h1>
        <nav>
            <a href="../index.php">Retour au site</a>
            <a href="../logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <h2>Produits</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo $product['price']; ?> fcfa</td>
                        <td><?php echo $product['stock']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Dernières Commandes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo $order['total']; ?> fcfa</td>
                        <td><?php echo $order['status']; ?></td>
                        <td><?php echo $order['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>