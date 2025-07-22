<?php
// src/views/layout.php

// Ce fichier définit la structure HTML de base pour toutes les pages de l'application.
// Il inclut l'en-tête, le contenu spécifique à la page et le pied de page.
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TaskList App' ?></title> <!-- Le titre de la page peut être défini dans chaque vue -->
    <link rel="stylesheet" href="/css/style.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <?php 
    // Inclut l'en-tête de la page (navigation, etc.)
    require_once __DIR__ . '/includes/header.php'; 
    ?>

    <main class="container">
        <?php 
        // Le contenu spécifique de chaque page sera inclus ici.
        // La variable $content est supposée contenir le chemin vers le fichier de vue.
        if (isset($content) && file_exists($content)) {
            require_once $content;
        }
        ?>
    </main>

    <?php 
    // Inclut le pied de page
    require_once __DIR__ . '/includes/footer.php'; 
    ?>
</body>
</html>