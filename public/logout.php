<?php
// public/logout.php

// Démarre la session PHP
session_start();

// Vide toutes les variables de session
$_SESSION = array();

// Si la session est gérée par des cookies, supprime aussi le cookie de session.
// Note: Cela détruira le cookie de session et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruit la session
session_destroy();

// Redirige l'utilisateur vers la page de connexion avec un message de succès
header('Location: /login.php?message=' . urlencode("Vous avez été déconnecté.") . '&type=success');
exit(); // Termine l'exécution du script
