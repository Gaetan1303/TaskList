<?php
// public/login.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

// Si l'utilisateur est déjà connecté, rediriger vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['message'] = 'Le nom d\'utilisateur et le mot de passe sont requis.';
        $_SESSION['message_type'] = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['message'] = 'Connexion réussie !';
                $_SESSION['message_type'] = 'success';
                header('Location: /index.php');
                exit();
            } else {
                $_SESSION['message'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
                $_SESSION['message_type'] = 'error';
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erreur lors de la connexion : " . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }
    header('Location: /login.php'); // Redirige pour afficher le message
    exit();
}

include __DIR__ . '/../templates/header.php';
?>

<h2>Connexion</h2>
<form action="/login.php" method="POST">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="/register.php">Inscrivez-vous ici</a></p>

<?php
include __DIR__ . '/../templates/footer.php';
?>