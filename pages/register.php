<?php
$error = null;
$success = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_btn'])) {
    // Registration logic will be implemented here
}
?>

<div class="auth-container">
    <h2 class="section-title auth-title">
        <i class="fa-solid fa-user-plus"></i> Inscription
    </h2>

    <div class="dark-form">
        <form action="register" method="POST">

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required placeholder="Votre pseudo tactique">
            </div>

            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" required placeholder="soldat@exemple.com">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••">
            </div>

            <button type="submit" name="register_btn" class="btn-primary btn-full-width">
                S'inscrire <i class="fa-solid fa-user-plus"></i>
            </button>

        </form>

        <div class="auth-footer">
            <p class="auth-text">
                Déjà en mission ?
                <a href="login" class="auth-link">
                    Se connecter
                </a>
            </p>
        </div>
    </div>

</div>