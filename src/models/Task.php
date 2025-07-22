<?php
// src/models/Task.php

require_once __DIR__ . '/../config/db.php';

function addTask($userId, $description) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, description) VALUES (?, ?)");
    return $stmt->execute([$userId, $description]);
}

function getTasksByUserId($userId) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function deleteTask($taskId, $userId) {
    $pdo = getDbConnection();
    // Assurez-vous que la tâche appartient bien à l'utilisateur connecté
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    return $stmt->execute([$taskId, $userId]);
}

// [BONUS]
function getTaskById($taskId, $userId) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$taskId, $userId]);
    return $stmt->fetch();
}

// [BONUS]
function toggleTaskCompletion($taskId, $userId, $isCompleted) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("UPDATE tasks SET is_completed = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$isCompleted, $taskId, $userId]);
}