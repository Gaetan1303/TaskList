<?php
// public/register.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['message'] = 'Le nom d\'utilisateur et le mot de passe sont requis.';
        $_SESSION['message_type'] = 'error';
    } else {
        try {
            // Vérifier si l'utilisateur existe déjà
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $_SESSION['message'] = 'Ce nom d\'utilisateur est déjà pris.';
                $_SESSION['message_type'] = 'error';
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $hashed_password]);

                $_SESSION['message'] = 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
                $_SESSION['message_type'] = 'success';
                header('Location: /login.php');
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erreur lors de l'inscription : " . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }
    header('Location: /register.php'); // Redirige pour afficher le message
    exit();
}

include __DIR__ . '/../templates/header.php';
?>

<h2>Inscription</h2>
<form action="/register.php" method="POST">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">S'inscrire</button>
</form>

<p>Déjà un compte ? <a href="/login.php">Connectez-vous ici</a></p>

<?php
include __DIR__ . '/../templates/footer.php';
?>