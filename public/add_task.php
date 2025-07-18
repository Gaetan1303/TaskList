<?php
// public/add_task.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'Vous devez être connecté pour ajouter une tâche.';
    $_SESSION['message_type'] = 'error';
    header('Location: /login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['user_id'];

    if (empty($title)) {
        $_SESSION['message'] = 'Le titre de la tâche est requis.';
        $_SESSION['message_type'] = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $title, $description]);

            $_SESSION['message'] = 'Tâche ajoutée avec succès !';
            $_SESSION['message_type'] = 'success';
            header('Location: /index.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erreur lors de l'ajout de la tâche : " . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }
    header('Location: /add_task.php'); // Redirige pour afficher le message
    exit();
}

include __DIR__ . '/../templates/header.php';
?>

<h2>Ajouter une nouvelle tâche</h2>
<form action="/add_task.php" method="POST">
    <label for="title">Titre :</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Description :</label>
    <textarea id="description" name="description" rows="5"></textarea>

    <button type="submit">Ajouter la tâche</button>
</form>

<?php
include __DIR__ . '/../templates/footer.php';
?>