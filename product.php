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

$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'], $_POST['comment'])) {
    if (!isset($_SESSION['user_id'])) {
        $errorMessage = 'Vous devez être connecté pour laisser un avis.';
    } else {
        $rating = max(1, min(5, intval($_POST['rating'])));
        $comment = trim($_POST['comment']);

        if ($comment === '') {
            $errorMessage = 'Veuillez écrire un commentaire.';
        } else {
            $stmt = $db->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $id, $rating, $comment]);
            header('Location: product.php?id=' . $id);
            exit;
        }
    }
}

$ratingInfo = getProductRating($db, $id);
$reviews = getProductReviews($db, $id);
?>
<!DOCTYPE html>
<html lang="fr">
<head:
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
            <?php $productImage = !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/600x400?text=Produit'; ?>
            <img class="product-detail-image" src="<?php echo htmlspecialchars($productImage); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <div class="product-meta">
                <span>Prix : <?php echo $product['price']; ?> €</span>
                <span>Stock : <?php echo $product['stock']; ?></span>
                <span>Note : <?php echo $ratingInfo['avg_rating'] > 0 ? number_format($ratingInfo['avg_rating'], 1) : 'N/A'; ?> / 5</span>
                <span><?php echo $ratingInfo['review_count']; ?> avis</span>
            </div>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <form action="add_to_cart.php" method="post" class="cart-form">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <label>Quantité :</label>
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>

        <section class="product-reviews">
            <h3>Avis clients</h3>
            <?php if (!empty($errorMessage)): ?>
                <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="post" class="review-form">
                    <label for="rating">Note :</label>
                    <select id="rating" name="rating">
                        <option value="5">5 étoiles</option>
                        <option value="4">4 étoiles</option>
                        <option value="3">3 étoiles</option>
                        <option value="2">2 étoiles</option>
                        <option value="1">1 étoile</option>
                    </select>
                    <label for="comment">Commentaire :</label>
                    <textarea id="comment" name="comment" rows="4" required></textarea>
                    <button type="submit">Publier mon avis</button>
                </form>
            <?php else: ?>
                <p><a href="login.php">Connectez-vous</a> pour laisser un avis.</p>
            <?php endif; ?>

            <?php if (empty($reviews)): ?>
                <p>Aucun avis pour le moment. Soyez le premier à noter ce produit.</p>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <div class="review-header">
                            <strong><?php echo htmlspecialchars($review['username']); ?></strong>
                            <span><?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?></span>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                        <small><?php echo htmlspecialchars($review['created_at']); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>