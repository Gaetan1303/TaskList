<?php
// src/models/User.php

require_once __DIR__ . '/../config/db.php';

function createUser($username, $password) {
    $pdo = getDbConnection();
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, $hashedPassword]);
}

function getUserByUsername($username) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();
}

function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}