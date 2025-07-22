<?php
// public/task_details.php

// Démarre la session PHP
session_start();

// Inclut le modèle de tâche
require_once __DIR__ . '/../src/models/Task.php';

$message = ''; // Variable pour stocker les messages à afficher à l'utilisateur
$messageType = ''; // Variable pour le type de message (success/error)

// Vérifie si l'utilisateur est connecté. Si non, redirige vers la page de connexion.
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php?message=' . urlencode("Veuillez vous connecter pour accéder à vos tâches.") . '&type=error');
    exit();
}

$userId = $_SESSION['user_id']; // Récupère l'ID de l'utilisateur connecté
$task = null; // Initialise la variable de tâche à null

// Vérifie si un ID de tâche est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $taskId = (int)$_GET['id']; // Récupère l'ID de la tâche et le convertit en entier

    // Récupère la tâche par son ID et l'ID de l'utilisateur pour s'assurer de l'appartenance
    $task = getTaskById($taskId, $userId);

    if (!$task) {
        $message = "La tâche spécifiée n'existe pas ou ne vous appartient pas.";
        $messageType = 'error';
    }
} else {
    $message = "Aucun ID de tâche spécifié.";
    $messageType = 'error';
}

// Définit le titre de la page
$title = "Détails de la Tâche - TaskList";
// Définit le chemin de la vue à inclure dans le layout
$content = __DIR__ . '/../src/views/task_details.php';

// Inclut le layout principal qui affichera le contenu de la vue
require_once __DIR__ . '/../src/views/layout.php';
