<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Utilisateur par défaut XAMPP
define('DB_PASS', ''); // Mot de passe vide par défaut
define('DB_NAME', 'ecommerce');

// Connexion à la base de données
function getDBConnection() {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}
?>