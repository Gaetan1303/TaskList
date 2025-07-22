<?php
// src/views/task_details.php

// This view displays the details of a specific task.
?>
<h2>Détails de la Tâche</h2>

<?php if (isset($message)): // Displays a message if the $message variable is set ?>
    <div class="message <?= $messageType ?? '' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if ($task): // Checks if the task was found ?>
    <div class="task-item">
        <p><strong>Description :</strong> <?= htmlspecialchars($task['description']) ?></p>
        <p><strong>Statut :</strong> <?= $task['is_completed'] ? 'Terminée' : 'En cours' ?></p>
        <p><strong>Créée le :</strong> <?= htmlspecialchars($task['created_at']) ?></p>
    </div>
    <p><a href="/" class="button">Retour à la liste des tâches</a></p>
<?php else: ?>
    <p>La tâche demandée n'existe pas ou ne vous appartient pas.</p>
    <p><a href="/" class="button">Retour à la liste des tâches</a></p>
<?php endif; ?>
