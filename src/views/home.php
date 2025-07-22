<?php
// src/views/home.php

// Cette vue affiche la liste des tâches de l'utilisateur connecté
// et le formulaire pour ajouter une nouvelle tâche.
?>
<h2>Mes Tâches</h2>

<?php if (isset($message)): // Affiche un message si la variable $message est définie ?>
    <div class="message <?= $messageType ?? '' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<h3>Ajouter une nouvelle tâche</h3>
<form action="/" method="POST">
    <div>
        <label for="description">Description de la tâche :</label>
        <textarea id="description" name="description" rows="3" required></textarea>
    </div>
    <button type="submit" name="action" value="add_task">Ajouter la tâche</button>
</form>

<h3>Liste de mes tâches</h3>
<?php if (empty($tasks)): // Vérifie si la liste des tâches est vide ?>
    <p>Vous n'avez pas encore de tâches. Ajoutez-en une !</p>
<?php else: ?>
    <ul class="task-list">
        <?php foreach ($tasks as $task): // Boucle sur chaque tâche pour l'afficher ?>
            <li class="task-item <?= $task['is_completed'] ? 'completed' : '' ?>">
                <span><?= htmlspecialchars($task['description']) ?></span>
                <div class="actions">
                    <a href="/task_details.php?id=<?= $task['id'] ?>" class="button">Détails</a>
                    <a href="/?action=toggle_complete&id=<?= $task['id'] ?>&status=<?= $task['is_completed'] ? '0' : '1' ?>" class="button">
                        <?= $task['is_completed'] ? 'Marquer non terminée' : 'Marquer terminée' ?>
                    </a>
                    <a href="/?action=delete&id=<?= $task['id'] ?>" class="button delete-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">Supprimer</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
