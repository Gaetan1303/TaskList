<?php
// src/views/register.php

// Cette vue affiche le formulaire d'inscription.
// Elle peut aussi afficher des messages d'erreur ou de succès.
?>
<h2>Inscription</h2>

<?php if (isset($message)): // Affiche un message si la variable $message est définie ?>
    <div class="message <?= $messageType ?? '' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<form action="/register.php" method="POST">
    <div>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">S'inscrire</button>
</form>

<p>Déjà un compte ? <a href="/login.php">Connectez-vous ici</a>.</p>