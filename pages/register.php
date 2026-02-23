<div class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon-circle">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="auth-title">Créer un Profil Tactique</h2>
            <p class="auth-subtitle">Rejoignez l'élite de l'équipement AT CFM</p>
        </div>

        <div class="dark-form glass-card">
            <form action="register" method="POST">

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i>
                        <?= htmlspecialchars($success, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-id-badge"></i>
                        <input type="text" id="username" name="username" required placeholder="Votre pseudo tactique"
                            value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="email" required placeholder="soldat@exemple.com"
                            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmation</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-shield-check"></i>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" name="register_btn" class="btn-primary btn-full-width btn-glow">
                    Initialiser l'inscription <i class="fa-solid fa-chevron-right"></i>
                </button>

            </form>

            <div class="auth-footer">
                <p class="auth-text">
                    Déjà en mission ?
                    <a href="login" class="auth-link">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>