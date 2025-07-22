<?php
// src/config/db.php

function getDbConnection() {
    $host = 'localhost';
    $db   = 'tasklist_db'; // Remplacez par le nom de votre base de données
    $user = 'root';        // Remplacez par votre utilisateur de base de données
    $pass = '';            // Remplacez par votre mot de passe de base de données
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}