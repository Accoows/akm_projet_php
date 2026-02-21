<?php
require_once 'config/database.php';

$error = null;
$success = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_btn'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            // Vérifier si l'utilisateur existe déjà
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM User WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $error = "Ce nom d'utilisateur ou cet email est déjà utilisé.";
            } else {
                // Création du compte
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $defaultAvatar = 'assets/images/placeholder_user.png';
                $initialBalance = 0.00;

                $stmtInsert = $pdo->prepare("INSERT INTO User (username, password, email, balance, profile_picture, role) VALUES (?, ?, ?, ?, ?, 'user')");
                if ($stmtInsert->execute([$username, $hashedPassword, $email, $initialBalance, $defaultAvatar])) {
                    $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                    echo "<script>setTimeout(function(){ window.location.replace('login'); }, 2000);</script>";
                } else {
                    $error = "Erreur lors de l'inscription.";
                }
            }
        } catch (PDOException $e) {
            $error = "Erreur base de données : " . $e->getMessage();
        }
    }
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
                <input type="text" id="username" name="username" required placeholder="Votre pseudo tactique"
                    value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" required placeholder="soldat@exemple.com"
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
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