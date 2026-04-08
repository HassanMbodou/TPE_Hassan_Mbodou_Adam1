<?php
session_start();
require 'config.php';
$db = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    try {
        $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $email]);
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $error = "Erreur lors de l'inscription.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Mon E-commerce</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="cart.php">Panier</a>
            <a href="login.php">Connexion</a>
        </nav>
    </header>
    <main>
        <h2>Inscription</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Nom d'utilisateur:</label>
            <input type="text" name="username" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Mot de passe:</label>
            <input type="password" name="password" required>
            <button type="submit">S'inscrire</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2026 Hassan E-commerce</p>
    </footer>
</body>
</html>