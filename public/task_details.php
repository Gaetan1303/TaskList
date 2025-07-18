<?php
// public/task_details.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'Vous devez être connecté pour voir les détails d\'une tâche.';
    $_SESSION['message_type'] = 'error';
    header('Location: /login.php');
    exit();
}

$task = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("SELECT id, title, description, completed, created_at FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$task_id, $user_id]);
        $task = $stmt->fetch();

        if (!$task) {
            $_SESSION['message'] = 'Tâche introuvable ou vous n\'avez pas les permissions pour la voir.';
            $_SESSION['message_type'] = 'error';
            header('Location: /index.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur lors du chargement de la tâche : " . $e->getMessage();
        $_SESSION['message_type'] = 'error';
        header('Location: /index.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'ID de tâche invalide.';
    $_SESSION['message_type'] = 'error';
    header('Location: /index.php');
    exit();
}

include __DIR__ . '/../templates/header.php';
?>

<?php if ($task): ?>
    <h2>Détails de la tâche : <?php echo htmlspecialchars($task['title']); ?></h2>
    <p><strong>Description :</strong> <?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
    <p><strong>Statut :</strong> <?php echo $task['completed'] ? 'Terminée' : 'En cours'; ?></p>
    <p><strong>Créée le :</strong> <?php echo date('d/m/Y H:i', strtotime($task['created_at'])); ?></p>
    <a href="/index.php">Retour à la liste des tâches</a>
<?php endif; ?>

<?php
include __DIR__ . '/../templates/footer.php';
?>