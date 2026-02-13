<?php
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {}
?>

<div style="max-width: 600px; margin: 40px auto;"> <h2 class="section-title" style="text-align: center;">
        <i class="fa-solid fa-user-lock"></i> Connexion
    </h2>

    <div class="dark-form">
        <form action="index.php?page=login" method="POST">
            
            <?php if ($error): ?>
                <div style="background-color: rgba(231, 76, 60, 0.2); border: 1px solid #e74c3c; color: #ffadad; padding: 10px; border-radius: 3px; margin-bottom: 20px;">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required placeholder="Votre pseudo tactique">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" name="login_btn" class="btn-primary" style="width: 100%; margin-top: 10px;">
                Se connecter <i class="fa-solid fa-arrow-right"></i>
            </button>

        </form>

        <div style="margin-top: 20px; text-align: center; border-top: 1px solid #444; padding-top: 20px;">
            <p style="color: #aaa; font-size: 0.9rem;">
                Nouvelle recrue ? 
                <a href="index.php?page=register" style="color: var(--bg-olive-light); text-decoration: none; font-weight: bold;">
                    Créer un compte
                </a>
            </p>
        </div>
    </div>

</div>