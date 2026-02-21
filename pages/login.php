<?php
require_once 'config/database.php';

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Succès
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'avatar' => $user['profile_picture']
                ];
                // Redirection JS car les headers sont déjà envoyés par index.php
                echo "<script>window.location.replace('account');</script>";
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de connexion.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<div class="auth-container">
    <h2 class="section-title auth-title">
        <i class="fa-solid fa-user-lock"></i> Connexion
    </h2>

    <div class="dark-form">
        <form action="login" method="POST">

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required placeholder="Votre pseudo tactique"
                    value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" name="login_btn" class="btn-primary btn-full-width">
                Se connecter <i class="fa-solid fa-arrow-right"></i>
            </button>

        </form>

        <div class="auth-footer">
            <p class="auth-text">
                Nouvelle recrue ?
                <a href="register" class="auth-link">
                    Créer un compte
                </a>
            </p>
        </div>
    </div>
</div>