<div class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon-circle">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <h2 class="auth-title">Authentification</h2>
            <p class="auth-subtitle">Accédez à votre inventaire et vos ordres</p>
        </div>

        <div class="dark-form glass-card">
            <form action="login" method="POST">

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="username" required placeholder="Votre pseudo tactique"
                            value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" name="login_btn" class="btn-primary btn-full-width btn-glow">
                    Se connecter <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>

            </form>

            <div class="auth-footer">
                <p class="auth-text">
                    Nouvelle recrue ?
                    <a href="register" class="auth-link">Créer un compte</a>
                </p>
            </div>
        </div>
    </div>
</div>