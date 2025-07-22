<?php
// src/views/login.php

// Cette vue affiche le formulaire de connexion.
// Elle peut aussi afficher des messages d'erreur ou de succès.
?>
<h2>Connexion</h2>

<?php if (isset($message)): // Affiche un message si la variable $message est définie ?>
    <div class="message <?= $messageType ?? '' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<form action="/login.php" method="POST">
    <div>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="/register.php">Inscrivez-vous ici</a>.</p>