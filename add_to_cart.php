<?php
session_start();
require 'config.php';
$db = getDBConnection();

if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    header('Location: index.php');
    exit;
}

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$session_id = session_id();

$stmt = $db->prepare("SELECT * FROM cart WHERE product_id = ? AND (user_id = ? OR session_id = ?)");
$stmt->execute([$product_id, $user_id, $session_id]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    $new_quantity = $existing['quantity'] + $quantity;
    $stmt = $db->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $stmt->execute([$new_quantity, $existing['id']]);
} else {
    $stmt = $db->prepare("INSERT INTO cart (user_id, product_id, quantity, session_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $product_id, $quantity, $session_id]);
}

header('Location: cart.php');
exit;
?>