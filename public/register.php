<?php
// public/register.php

// Démarre la session PHP
session_start();

// Inclut le modèle utilisateur pour les fonctions CRUD
require_once __DIR__ . '/../src/models/User.php';

$message = ''; // Variable pour stocker les messages à afficher à l'utilisateur
$messageType = ''; // Variable pour le type de message (success/error)

// Vérifie si le formulaire a été soumis (méthode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si les champs 'username' et 'password' sont définis et non vides
    if (isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['password']) && !empty($_POST['password'])) {

        $username = trim($_POST['username']); // Récupère et nettoie le nom d'utilisateur
        $password = $_POST['password'];       // Récupère le mot de passe

        // Tente de créer l'utilisateur
        if (createUser($username, $password)) {
            $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            $messageType = 'success';
            // Redirige vers la page de connexion après une inscription réussie
            header('Location: /login.php?message=' . urlencode($message) . '&type=success');
            exit(); // Termine l'exécution du script
        } else {
            // Si la création échoue (ex: nom d'utilisateur déjà pris)
            $message = "Erreur lors de l'inscription. Le nom d'utilisateur existe peut-être déjà.";
            $messageType = 'error';
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        $messageType = 'error';
    }
}

// Définit le titre de la page
$title = "Inscription - TaskList";
// Définit le chemin de la vue à inclure dans le layout
$content = __DIR__ . '/../src/views/register.php';

// Inclut le layout principal qui affichera le contenu de la vue
require_once __DIR__ . '/../src/views/layout.php';