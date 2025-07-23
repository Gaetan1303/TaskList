# TaskListProjet TaskList - Application de Gestion de Tâches
Table des Matières

    Introduction
    Fonctionnalités
    Prérequis
    Installation
        Configuration de la Base de Données
        Lancement du Serveur PHP
    Utilisation
    Structure du Projet
    Technologies Utilisées
    Auteur

1. Introduction

TaskList est une application web simple de gestion de tâches personnelles. Elle permet aux utilisateurs de s'inscrire, de se connecter et de gérer leurs propres listes de tâches. Chaque utilisateur peut ajouter, supprimer et marquer ses tâches comme terminées. L'application est développée en PHP avec une base de données MySQL pour le stockage des données.
2. Fonctionnalités

    Inscription des Utilisateurs : Permet aux nouveaux utilisateurs de créer un compte avec un nom d'utilisateur et un mot de passe (chiffré avec Bcrypt).
    Connexion et Déconnexion : Authentifie les utilisateurs existants et gère les sessions de connexion.
    Gestion des Tâches Personnelles : Chaque utilisateur voit et gère uniquement ses propres tâches.
    Ajout de Tâches : Formulaire pour ajouter de nouvelles tâches.
    Suppression de Tâches : Possibilité de supprimer des tâches existantes.
    [BONUS] Validation de Tâches : Marquer une tâche comme terminée ou non terminée.
    [BONUS] Page de Détails de Tâche : Afficher les informations détaillées d'une tâche spécifique.

3. Prérequis

Avant de lancer l'application, assurez-vous d'avoir les éléments suivants installés sur votre système :

    Serveur Web : Un serveur web capable d'exécuter PHP (par exemple, Apache, Nginx, ou le serveur web intégré de PHP).
    PHP : Version 7.4 ou supérieure recommandée.
    MySQL : Un serveur de base de données MySQL.
    Extension PHP PDO (MySQL) : L'extension PDO pour MySQL doit être activée dans votre configuration PHP (php.ini).

4. Installation

Suivez les étapes ci-dessous pour installer et configurer le projet TaskList.
Configuration de la Base de Données

    Créez une base de données :
    Accédez à votre serveur MySQL (via phpMyAdmin, MySQL Workbench ou la ligne de commande) et créez une nouvelle base de données nommée tasklist_db.

    CREATE DATABASE IF NOT EXISTS tasklist_db;
    USE tasklist_db;

    Exécutez le schéma SQL :
    Exécutez les requêtes SQL suivantes pour créer les tables users et tasks :

    -- Table pour les utilisateurs
    CREATE
     TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    );

    -- Table pour les tâches
    CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        description TEXT NOT NULL,
        is_completed BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );

    Configurez la connexion à la base de données :
    Ouvrez le fichier src/config/db.php et ajustez les informations de connexion si nécessaire (utilisateur, mot de passe, nom de la base de données) :

    // src/config/db.php
    $host = '127.0.0.1';
    $db   = 'tasklist_db'; // Votre nom de base de données
    $user = 'root';        // Votre utilisateur MySQL
    $pass = 'root';            // Votre mot de passe MySQL
    $charset = 'utf8mb4';

Lancement du Serveur PHP

    Naviguez vers le répertoire public :
    Ouvrez votre terminal ou invite de commandes et naviguez jusqu'au dossier public de votre projet TaskList :

    cd /chemin/vers/votre/projet/TaskList/public

    Lancez le serveur web intégré de PHP :
    Exécutez la commande suivante :

    php -S localhost:8000

    Cela lancera un serveur web sur http://localhost:8000.

    Accédez à l'application :
    Ouvrez votre navigateur web et visitez l'adresse :
    http://localhost:8000

    Note : Si vous utilisez Apache ou Nginx, configurez votre hôte virtuel pour pointer vers le dossier public et assurez-vous que mod_rewrite est activé pour que les URLs propres fonctionnent avec le fichier .htaccess fourni à la racine du projet.

5. Utilisation

    Inscription : Sur la page d'accueil, cliquez sur "Inscription" pour créer un nouveau compte.
    Connexion : Après l'inscription ou si vous avez déjà un compte, cliquez sur "Connexion" et entrez vos identifiants.

    Gestion des Tâches :

        Ajouter une tâche : Utilisez le formulaire "Ajouter une nouvelle tâche" sur la page d'accueil.
        Supprimer une tâche : Cliquez sur le bouton "Supprimer" à côté de la tâche.
        Marquer comme terminée/non terminée : Cliquez sur le bouton correspondant pour changer le statut de la tâche.
        Voir les détails : Cliquez sur "Détails" pour afficher les informations complètes d'une tâche.
    Déconnexion : Cliquez sur "Déconnexion" dans la barre de navigation pour terminer votre session.

6. Structure du Projet

TaskList/
├── public/                 # Point d'entrée de l'application (accessible via le navigateur)
│ ├── index.php             # Contrôleur frontal principal
│ ├── login.php             # Logique de connexion
│ ├── register.php          # Logique d'inscription
│ ├── logout.php            # Logique de déconnexion
│ ├── task_details.php      # Logique des détails de tâche (BONUS)
│ └── css/
│     └── style.css         # Styles CSS de l'application
├── src/                    # Code source de l'application
│ ├── config/
│ │ └── db.php              # Configuration de la connexion à la base de données
│ ├── models/
│ │ ├── User.php            # Fonctions CRUD pour la table 'users'
│ │ └── Task.php            # Fonctions CRUD pour la table 'tasks'
│ ├── controllers/          # Logique métier (non directement utilisée dans cette version simple, mais bonne pratique)
│ │ ├── AuthController.php
│ │ └── TaskController.php
│ └── views/                # Fichiers de présentation (HTML avec PHP)
│     ├── layout.php        # Modèle de mise en page général
│     ├── home.php          # Vue de la page d'accueil (liste des tâches)
│     ├── login.php         # Vue du formulaire de connexion
│     ├── register.php      # Vue du formulaire d'inscription
│     ├── task_details.php  # Vue des détails d'une tâche (BONUS)
│     └── includes/
│         ├── header.php    # En-tête commun (navigation)
│         └── footer.php    # Pied de page commun
└── .htaccess               # Fichier de configuration Apache pour la réécriture d'URL



7. Technologies Utilisées

    PHP
    MySQL
    PDO (PHP Data Objects)
    HTML5
    CSS3

8. Auteur

Gaetan1303