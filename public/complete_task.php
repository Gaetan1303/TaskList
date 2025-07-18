<?php
// public/complete_task.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'Vous devez être connecté pour marquer une tâche comme terminée.';
    $_SESSION['message_type'] = 'error';
    header('Location: /login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'] ?? null;
    $user_id = $_SESSION['user_id'];

    if (!isset($task_id) || !is_numeric($task_id)) {
        $_SESSION['message'] = 'ID de tâche invalide.';
        $_SESSION['message_type'] = 'error';
    } else {
        try {
            // Mettre à jour le statut 'completed' de la tâche, en s'assurant qu'elle appartient à l'utilisateur
            $stmt = $pdo->prepare("UPDATE tasks SET completed = TRUE WHERE id = ? AND user_id = ?");
            $stmt->execute([$task_id, $user_id]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['message'] = 'Tâche marquée comme terminée !';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Tâche introuvable ou vous n\'avez pas les permissions pour la marquer comme terminée.';
                $_SESSION['message_type'] = 'error';
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erreur lors de la mise à jour de la tâche : " . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }
} else {
    $_SESSION['message'] = 'Accès non autorisé.';
    $_SESSION['message_type'] = 'error';
}

header('Location: /index.php');
exit();
?>