<?php
require 'config.php';
header('Content-Type: application/json');
$db = getDBConnection();

$resource = $_GET['resource'] ?? '';

function respond($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

switch ($resource) {
    case 'products':
        $stmt = $db->query("SELECT * FROM products ORDER BY created_at DESC");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as &$product) {
            $rating = getProductRating($db, $product['id']);
            $product['rating'] = $rating['avg_rating'];
            $product['review_count'] = $rating['review_count'];
        }
        respond(['products' => $products]);
        break;

    case 'product':
        if (!isset($_GET['id'])) {
            respond(['error' => 'ID de produit requis'], 400);
        }
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            respond(['error' => 'Produit introuvable'], 404);
        }
        $rating = getProductRating($db, $product['id']);
        $product['rating'] = $rating['avg_rating'];
        $product['review_count'] = $rating['review_count'];
        respond(['product' => $product]);
        break;

    case 'reviews':
        if (!isset($_GET['product_id'])) {
            respond(['error' => 'ID de produit requis'], 400);
        }
        $stmt = $db->prepare("SELECT r.rating, r.comment, r.created_at, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = ? ORDER BY r.created_at DESC");
        $stmt->execute([$_GET['product_id']]);
        respond(['reviews' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        break;

    case 'submit_review':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            respond(['error' => 'Méthode non autorisée'], 405);
        }
        session_start();
        if (!isset($_SESSION['user_id'])) {
            respond(['error' => 'Utilisateur non connecté'], 401);
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;
        $rating = intval($data['rating'] ?? 0);
        $comment = trim($data['comment'] ?? '');

        if (!$productId || $rating < 1 || $rating > 5 || $comment === '') {
            respond(['error' => 'Données de review invalides'], 400);
        }

        $stmt = $db->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $productId, $rating, $comment]);
        respond(['success' => true]);
        break;

    default:
        respond(['error' => 'Ressource API non trouvée'], 404);
}
?>