<?php
// src/controllers/TaskController.php

// Inclut le modèle Task pour interagir avec la base de données des tâches
require_once __DIR__ . '/../models/Task.php';

/**
 * Récupère toutes les tâches pour un utilisateur donné.
 * @param int $userId L'ID de l'utilisateur.
 * @return array Un tableau de tâches.
 */
function getUserTasks($userId) {
    return getTasksByUserId($userId);
}

/**
 * Ajoute une nouvelle tâche pour un utilisateur.
 * @param int $userId L'ID de l'utilisateur.
 * @param string $description La description de la tâche.
 * @return array Un tableau associatif contenant 'success' (bool) et 'message' (string).
 */
function addNewTask($userId, $description) {
    // Vérifie si la description est vide
    if (empty(trim($description))) {
        return ['success' => false, 'message' => "La description de la tâche ne peut pas être vide."];
    }

    // Tente d'ajouter la tâche via le modèle
    if (addTask($userId, $description)) {
        return ['success' => true, 'message' => "Tâche ajoutée avec succès !"];
    } else {
        return ['success' => false, 'message' => "Erreur lors de l'ajout de la tâche."];
    }
}

/**
 * Supprime une tâche spécifique pour un utilisateur.
 * @param int $taskId L'ID de la tâche à supprimer.
 * @param int $userId L'ID de l'utilisateur propriétaire de la tâche.
 * @return array Un tableau associatif contenant 'success' (bool) et 'message' (string).
 */
function removeTask($taskId, $userId) {
    // Vérifie si l'ID de tâche est valide
    if ($taskId <= 0) {
        return ['success' => false, 'message' => "ID de tâche invalide."];
    }

    // Tente de supprimer la tâche via le modèle
    if (deleteTask($taskId, $userId)) {
        return ['success' => true, 'message' => "Tâche supprimée avec succès !"];
    } else {
        return ['success' => false, 'message' => "Erreur lors de la suppression de la tâche ou tâche non trouvée."];
    }
}

/**
 * [BONUS] Récupère les détails d'une tâche spécifique pour un utilisateur.
 * @param int $taskId L'ID de la tâche.
 * @param int $userId L'ID de l'utilisateur propriétaire de la tâche.
 * @return array|null Un tableau associatif contenant les détails de la tâche, ou null si non trouvée.
 */
function getTaskDetails($taskId, $userId) {
    // Vérifie si l'ID de tâche est valide
    if ($taskId <= 0) {
        return null; // Ou retourner un message d'erreur approprié
    }
    return getTaskById($taskId, $userId);
}

/**
 * [BONUS] Bascule le statut de complétion d'une tâche.
 * @param int $taskId L'ID de la tâche.
 * @param int $userId L'ID de l'utilisateur propriétaire de la tâche.
 * @param bool $isCompleted Le nouveau statut de complétion (true pour terminée, false pour non terminée).
 * @return array Un tableau associatif contenant 'success' (bool) et 'message' (string).
 */
function toggleCompletionStatus($taskId, $userId, $isCompleted) {
    // Vérifie si l'ID de tâche est valide
    if ($taskId <= 0) {
        return ['success' => false, 'message' => "ID de tâche invalide."];
    }

    // Tente de mettre à jour le statut via le modèle
    if (toggleTaskCompletion($taskId, $userId, $isCompleted)) {
        return ['success' => true, 'message' => "Statut de la tâche mis à jour !"];
    } else {
        return ['success' => false, 'message' => "Erreur lors de la mise à jour du statut de la tâche ou tâche non trouvée."];
    }
}
