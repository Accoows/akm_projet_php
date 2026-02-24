<?php


$error = null;
$success = null;

if (isPost() && isset($_POST['register_btn'])) {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            // Check if the given username or email already exists in the database
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM User WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $error = "Ce nom d'utilisateur ou cet email est déjà utilisé.";
            } else {
                // Apply a secure hash to the password before database insertion
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $defaultAvatar = 'assets/images/placeholder_user.png';
                $initialBalance = 0.00;

                // Create the new user with a standard 'user' role
                $stmtInsert = $pdo->prepare("INSERT INTO User (username, password, email, balance, profile_picture, role) VALUES (?, ?, ?, ?, ?, 'user')");
                if ($stmtInsert->execute([$username, $hashedPassword, $email, $initialBalance, $defaultAvatar])) {
                    $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                    redirect("login");
                } else {
                    $error = "Erreur lors de l'inscription.";
                }
            }
        } catch (PDOException $e) {
            $error = "Erreur base de données : " . $e->getMessage();
        }
    }
}
