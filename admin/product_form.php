<?php
session_start();
require '../config.php';
$db = getDBConnection();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    echo "Accès refusé.";
    exit;
}

$action = $_GET['action'] ?? 'add';
$product = [
    'name' => '',
    'description' => '',
    'price' => '',
    'stock' => '',
    'image' => ''
];

if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        echo "Produit introuvable.";
        exit;
    }
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = trim($_POST['image']);

    if ($name === '' || $price <= 0) {
        $errorMessage = 'Le nom et le prix sont requis.';
    } else {
        if ($action === 'edit' && isset($_GET['id'])) {
            $stmt = $db->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, stock = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $image, $stock, $_GET['id']]);
        } else {
            $stmt = $db->prepare("INSERT INTO products (name, description, price, image, stock) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $image, $stock]);
        }

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $action === 'edit' ? 'Modifier le produit' : 'Ajouter un produit'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Gestion des produits</h1>
        <nav>
            <a href="index.php">Retour</a>
            <a href="../logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <h2><?php echo $action === 'edit' ? 'Modifier le produit' : 'Ajouter un produit'; ?></h2>
        <?php if ($errorMessage): ?>
            <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
        <form method="post" class="review-form">
            <label>Nom du produit :</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label>Description :</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label>Prix :</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <label>Stock :</label>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>

            <label>URL de l'image :</label>
            <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">

            <button type="submit"><?php echo $action === 'edit' ? 'Mettre à jour' : 'Ajouter'; ?></button>
        </form>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>