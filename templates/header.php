<?php
// templates/header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskList</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { width: 80%; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        .navbar { background-color: #333; color: white; padding: 10px 20px; text-align: center; }
        .navbar a { color: white; text-decoration: none; margin: 0 15px; }
        .navbar a:hover { text-decoration: underline; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        form { margin-top: 20px; }
        form label { display: block; margin-bottom: 5px; font-weight: bold; }
        form input[type="text"], form input[type="password"], form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        form button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #4cae4c;
        }
        .task-list ul { list-style: none; padding: 0; }
        .task-list li { background-color: #e9e9e9; margin-bottom: 10px; padding: 10px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
        .task-list li.completed { text-decoration: line-through; opacity: 0.7; }
        .task-list li a { text-decoration: none; color: #007bff; margin-left: 10px; }
        .task-list li a:hover { text-decoration: underline; }
        .task-actions { display: flex; gap: 5px; }
        .delete-btn { background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        .complete-btn { background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="/index.php">Accueil</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/add_task.php">Ajouter une tâche</a>
            <a href="/logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="/login.php">Connexion</a>
            <a href="/register.php">Inscription</a>
        <?php endif; ?>
    </div>
    <div class="container">
<?php
// Affichage des messages flash
if (isset($_SESSION['message'])) {
    echo '<div class="message ' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>