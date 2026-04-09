<?php
session_start();
require '../config.php';
$db = getDBConnection();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    echo "Accès refusé.";
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php');
    exit;
}

$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Produit introuvable.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer le produit</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Suppression du produit</h1>
        <nav>
            <a href="index.php">Retour</a>
            <a href="../logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <h2>Confirmer la suppression</h2>
        <p>Voulez-vous vraiment supprimer le produit <strong><?php echo htmlspecialchars($product['name']); ?></strong> ?</p>
        <form method="post">
            <button type="submit">Oui, supprimer</button>
            <a class="button" href="index.php">Annuler</a>
        </form>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>