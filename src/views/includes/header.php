<?php
// src/views/includes/header.php

// Cette partie du code est incluse dans le layout principal et gère la navigation.
// Elle affiche des liens différents selon que l'utilisateur est connecté ou non.
?>
<nav>
    <a href="/">Accueil</a>
    <?php if (isset($_SESSION['user_id'])): // Si l'utilisateur est connecté ?>
        <a href="/logout.php">Déconnexion</a>
    <?php else: // Si l'utilisateur n'est pas connecté ?>
        <a href="/login.php">Connexion</a>
        <a href="/register.php">Inscription</a>
    <?php endif; ?>
</nav>
