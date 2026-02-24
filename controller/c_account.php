<?php
// controller/c_account.php

$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_profile') {
    $newUsername = trim($_POST['username'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');
    $newPassword = $_POST['password'] ?? '';
    $newPasswordConfirm = $_POST['password_confirm'] ?? '';
    
    if (!empty($newUsername) && !empty($newEmail)) {
        if (!empty($newPassword) && $newPassword !== $newPasswordConfirm) {
            $error_msg = "Les mots de passe ne correspondent pas.";
        } else {
            try {
                $stmtCheck = $pdo->prepare("SELECT id FROM User WHERE (email = ? OR username = ?) AND id != ?");
                $stmtCheck->execute([$newEmail, $newUsername, $userId]);
                if ($stmtCheck->rowCount() > 0) {
                    $error_msg = "L'email ou le nom d'utilisateur est déjà utilisé.";
                } else {
                    if (!empty($newPassword)) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $stmtUpdate = $pdo->prepare("UPDATE User SET username = ?, email = ?, password = ? WHERE id = ?");
                        $stmtUpdate->execute([$newUsername, $newEmail, $hashedPassword, $userId]);
                    } else {
                        $stmtUpdate = $pdo->prepare("UPDATE User SET username = ?, email = ? WHERE id = ?");
                        $stmtUpdate->execute([$newUsername, $newEmail, $userId]);
                    }
                    
                    $_SESSION['user']['username'] = $newUsername;
                    $_SESSION['user']['email'] = $newEmail;
                    $success_msg = "Vos informations ont été mises à jour avec succès.";
                }
            } catch (PDOException $e) {
                $error_msg = "Erreur lors de la mise à jour.";
            }
        }
    } else {
        $error_msg = "Veuillez remplir tous les champs.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_balance') {
    $newBalance = filter_var($_POST['balance'], FILTER_VALIDATE_FLOAT);
    
    if ($newBalance !== false && $newBalance >= 0) {
        try {
            $stmtUpdateBalance = $pdo->prepare("UPDATE User SET balance = ? WHERE id = ?");
            $stmtUpdateBalance->execute([$newBalance, $userId]);
            
            $_SESSION['user']['balance'] = $newBalance;
            $success_msg = "Votre solde a été mis à jour avec succès.";
        } catch (PDOException $e) {
            $error_msg = "Erreur lors de la mise à jour du solde.";
        }
    } else {
        $error_msg = "Veuillez entrer un montant valide (supérieur ou égal à 0).";
    }
}

$user = [];
$invoices = [];
$myArticles = [];

try {
    $stmtUser = $pdo->prepare("SELECT * FROM User WHERE id = ?");
    $stmtUser->execute([$userId]);
    $user = $stmtUser->fetch();

    if ($user) {
        $_SESSION['user']['balance'] = $user['balance'];
    }

    $stmtInv = $pdo->prepare("SELECT * FROM Invoice WHERE user_id = ? ORDER BY transaction_date DESC");
    $stmtInv->execute([$userId]);
    $invoices = $stmtInv->fetchAll();

    $stmtMyArt = $pdo->prepare("SELECT a.*, s.quantity FROM Article a LEFT JOIN Stock s ON a.id = s.article_id WHERE a.author_id = ? ORDER BY a.id DESC");
    $stmtMyArt->execute([$userId]);
    $myArticles = $stmtMyArt->fetchAll();

} catch (PDOException $e) {
    // Silent error
}
