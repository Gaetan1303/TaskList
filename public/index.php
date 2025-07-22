<?php
// public/index.php

// Démarre la session PHP
session_start();

// Inclut les modèles nécessaires
require_once __DIR__ . '/../src/models/Task.php';
require_once __DIR__ . '/../src/models/User.php'; // Peut être utile pour d'autres infos utilisateur si besoin

$message = ''; // Variable pour stocker les messages à afficher à l'utilisateur
$messageType = ''; // Variable pour le type de message (success/error)

// Vérifie si l'utilisateur est connecté. Si non, redirige vers la page de connexion.
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php?message=' . urlencode("Veuillez vous connecter pour accéder à vos tâches.") . '&type=error');
    exit();
}

$userId = $_SESSION['user_id']; // Récupère l'ID de l'utilisateur connecté

// --- Gestion des actions POST (Ajout de tâche) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_task') {
    if (isset($_POST['description']) && !empty(trim($_POST['description']))) {
        $description = trim($_POST['description']);
        if (addTask($userId, $description)) {
            $message = "Tâche ajoutée avec succès !";
            $messageType = 'success';
        } else {
            $message = "Erreur lors de l'ajout de la tâche.";
            $messageType = 'error';
        }
    } else {
        $message = "La description de la tâche ne peut pas être vide.";
        $messageType = 'error';
    }
    // Redirige pour éviter la soumission multiple du formulaire et afficher le message
    header('Location: /?message=' . urlencode($message) . '&type=' . urlencode($messageType));
    exit();
}

// --- Gestion des actions GET (Suppression et Validation/Dévalidation de tâche) ---
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $taskId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($taskId > 0) {
        switch ($action) {
            case 'delete':
                if (deleteTask($taskId, $userId)) {
                    $message = "Tâche supprimée avec succès !";
                    $messageType = 'success';
                } else {
                    $message = "Erreur lors de la suppression de la tâche ou tâche non trouvée.";
                    $messageType = 'error';
                }
                break;

            case 'toggle_complete':
                $status = isset($_GET['status']) ? (bool)$_GET['status'] : false; // '0' ou '1'
                if (toggleTaskCompletion($taskId, $userId, $status)) {
                    $message = "Statut de la tâche mis à jour !";
                    $messageType = 'success';
                } else {
                    $message = "Erreur lors de la mise à jour du statut de la tâche ou tâche non trouvée.";
                    $messageType = 'error';
                }
                break;

            default:
                $message = "Action non reconnue.";
                $messageType = 'error';
                break;
        }
    } else {
        $message = "ID de tâche invalide.";
        $messageType = 'error';
    }
    // Redirige pour afficher le message et nettoyer l'URL
    header('Location: /?message=' . urlencode($message) . '&type=' . urlencode($messageType));
    exit();
}

// --- Récupération et affichage des messages d'URL après redirection ---
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    $messageType = htmlspecialchars($_GET['type'] ?? '');
}

// --- Récupération des tâches de l'utilisateur pour l'affichage ---
$tasks = getTasksByUserId($userId);

// Définit le titre de la page
$title = "Mes Tâches - TaskList";
// Définit le chemin de la vue à inclure dans le layout
$content = __DIR__ . '/../src/views/home.php';

// Inclut le layout principal qui affichera le contenu de la vue
require_once __DIR__ . '/../src/views/layout.php';