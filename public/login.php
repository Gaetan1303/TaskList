<?php
// public/login.php

// Démarre la session PHP
session_start();

// Inclut le modèle utilisateur pour les fonctions CRUD
require_once __DIR__ . '/../src/models/User.php';

$message = ''; // Variable pour stocker les messages à afficher à l'utilisateur
$messageType = ''; // Variable pour le type de message (success/error)

// Vérifie si un message a été passé via l'URL (ex: après inscription réussie)
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    $messageType = htmlspecialchars($_GET['type'] ?? '');
}

// Vérifie si l'utilisateur est déjà connecté, si oui, redirige vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit();
}

// Vérifie si le formulaire a été soumis (méthode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si les champs 'username' et 'password' sont définis et non vides
    if (isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['password']) && !empty($_POST['password'])) {

        $username = trim($_POST['username']); // Récupère et nettoie le nom d'utilisateur
        $password = $_POST['password'];       // Récupère le mot de passe

        // Récupère l'utilisateur par son nom d'utilisateur
        $user = getUserByUsername($username);

        // Vérifie si un utilisateur a été trouvé et si le mot de passe correspond
        if ($user && verifyPassword($password, $user['password'])) {
            // Authentification réussie : stocke l'ID de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            // Redirige vers la page d'accueil
            header('Location: /');
            exit(); // Termine l'exécution du script
        } else {
            // Identifiants invalides
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
            $messageType = 'error';
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        $messageType = 'error';
    }
}

// Définit le titre de la page
$title = "Connexion - TaskList";
// Définit le chemin de la vue à inclure dans le layout
$content = __DIR__ . '/../src/views/login.php';

// Inclut le layout principal qui affichera le contenu de la vue
require_once __DIR__ . '/../src/views/layout.php';