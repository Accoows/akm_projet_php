<?php


$error = null;

if (isPost() && isset($_POST['login_btn'])) {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'avatar' => $user['profile_picture']
                ];
                
                redirect("account");
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
