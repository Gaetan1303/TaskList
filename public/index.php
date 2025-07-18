<?php
// public/index.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'Vous devez être connecté pour accéder à cette page.';
    $_SESSION['message_type'] = 'error';
    header('Location: /login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$tasks = [];

try {
    $stmt = $pdo->prepare("SELECT id, title, description, completed FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $tasks = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['message'] = "Erreur lors du chargement des tâches : " . $e->getMessage();
    $_SESSION['message_type'] = 'error';
}

include __DIR__ . '/../templates/header.php';
?>

<h1>Bienvenue sur votre TaskList !</h1>

<?php
include __DIR__ . '/../templates/task_list.php';
?>

<?php
include __DIR__ . '/../templates/footer.php';
?>