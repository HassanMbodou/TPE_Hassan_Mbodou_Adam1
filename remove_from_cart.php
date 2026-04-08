<?php
session_start();
require 'config.php';
$db = getDBConnection();

if (!isset($_GET['id'])) {
    header('Location: cart.php');
    exit;
}

$id = $_GET['id'];
$stmt = $db->prepare("DELETE FROM cart WHERE id = ?");
$stmt->execute([$id]);

header('Location: cart.php');
exit;
?>