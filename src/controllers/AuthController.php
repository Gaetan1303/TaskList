<?php
// src/controllers/AuthController.php

// Inclut le modèle User pour interagir avec la base de données des utilisateurs
require_once __DIR__ . '/../models/User.php';

/**
 * Gère le processus d'inscription d'un nouvel utilisateur.
 * @param string $username Le nom d'utilisateur fourni par le formulaire.
 * @param string $password Le mot de passe fourni par le formulaire.
 * @return array Un tableau associatif contenant 'success' (bool) et 'message' (string).
 */
function registerUser($username, $password) {
    // Vérifie si les champs sont vides
    if (empty($username) || empty($password)) {
        return ['success' => false, 'message' => "Veuillez remplir tous les champs."];
    }

    // Tente de créer l'utilisateur via le modèle
    if (createUser($username, $password)) {
        return ['success' => true, 'message' => "Inscription réussie ! Vous pouvez maintenant vous connecter."];
    } else {
        // En cas d'échec (ex: nom d'utilisateur déjà pris)
        return ['success' => false, 'message' => "Erreur lors de l'inscription. Le nom d'utilisateur existe peut-être déjà."];
    }
}

/**
 * Gère le processus de connexion d'un utilisateur.
 * @param string $username Le nom d'utilisateur fourni par le formulaire.
 * @param string $password Le mot de passe fourni par le formulaire.
 * @return array Un tableau associatif contenant 'success' (bool), 'message' (string) et 'user_id' (int|null).
 */
function loginUser($username, $password) {
    // Vérifie si les champs sont vides
    if (empty($username) || empty($password)) {
        return ['success' => false, 'message' => "Veuillez remplir tous les champs.", 'user_id' => null];
    }

    // Récupère l'utilisateur par son nom d'utilisateur
    $user = getUserByUsername($username);

    // Vérifie si l'utilisateur existe et si le mot de passe est correct
    if ($user && verifyPassword($password, $user['password'])) {
        // Connexion réussie : retourne l'ID de l'utilisateur
        return ['success' => true, 'message' => "Connexion réussie !", 'user_id' => $user['id']];
    } else {
        // Identifiants invalides
        return ['success' => false, 'message' => "Nom d'utilisateur ou mot de passe incorrect.", 'user_id' => null];
    }
}

/**
 * Gère le processus de déconnexion d'un utilisateur.
 * Détruit la session.
 */
function logoutUser() {
    session_start(); // S'assure que la session est démarrée pour pouvoir la détruire
    $_SESSION = array(); // Vide toutes les variables de session

    // Si la session utilise des cookies, supprime le cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); // Détruit la session sur le serveur
}