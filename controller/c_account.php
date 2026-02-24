<?php
// controller/c_account.php

$loggedInUserId = $_SESSION['user']['id'];
$isPublicProfile = false;
$userId = $loggedInUserId;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $requestedId = (int)$_GET['id'];
    if ($requestedId !== $loggedInUserId) {
        $isPublicProfile = true;
        $userId = $requestedId;
    }
}

// N'autoriser les POST (modifications) que si l'utilisateur consulte SON propre espace
if (!$isPublicProfile && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_profile') {
    $newUsername = trim($_POST['username'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');
    $newPassword = $_POST['password'] ?? '';
    $newPasswordConfirm = $_POST['password_confirm'] ?? '';
    
    // Handle Profile Picture
    $profilePicturePath = null;
    $uploadOk = true;
    $deletePicture = isset($_POST['delete_picture']) && $_POST['delete_picture'] == '1';
    $oldPicture = $_SESSION['user']['profile_picture'] ?? null;
    
    // Check if new file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'profile_' . $userId . '_' . time() . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $destPath)) {
                $profilePicturePath = $destPath;
                // Delete old picture since a new one was just successfully uploaded
                if (!empty($oldPicture) && file_exists($oldPicture) && strpos($oldPicture, 'uploads/profiles/') !== false) {
                    unlink($oldPicture);
                }
            } else {
                $error_msg = "Erreur lors de l'upload de l'image.";
                $uploadOk = false;
            }
        } else {
            $error_msg = "Format d'image non autorisé (JPG, PNG, WEBP, GIF uniquement).";
            $uploadOk = false;
        }
    } elseif ($deletePicture && !empty($oldPicture)) {
        // Delete old picture if checkbox was checked and no new image was uploaded
        if (file_exists($oldPicture) && strpos($oldPicture, 'uploads/profiles/') !== false) {
            unlink($oldPicture);
        }
        $profilePicturePath = 'DELETE'; // Special flag to unset DB column
    }
    
    if ($uploadOk && !empty($newUsername) && !empty($newEmail)) {
        if (!empty($newPassword) && $newPassword !== $newPasswordConfirm) {
            $error_msg = "Les mots de passe ne correspondent pas.";
        } else {
            try {
                $stmtCheck = $pdo->prepare("SELECT id FROM User WHERE (email = ? OR username = ?) AND id != ?");
                $stmtCheck->execute([$newEmail, $newUsername, $userId]);
                if ($stmtCheck->rowCount() > 0) {
                    $error_msg = "L'email ou le nom d'utilisateur est déjà utilisé.";
                } else {
                    $updateQuery = "UPDATE User SET username = ?, email = ?";
                    $updateParams = [$newUsername, $newEmail];
                    
                    if (!empty($newPassword)) {
                        $updateQuery .= ", password = ?";
                        $updateParams[] = password_hash($newPassword, PASSWORD_DEFAULT);
                    }
                    
                    if ($profilePicturePath === 'DELETE') {
                        $updateQuery .= ", profile_picture = NULL";
                    } elseif ($profilePicturePath) {
                        $updateQuery .= ", profile_picture = ?";
                        $updateParams[] = $profilePicturePath;
                    }
                    
                    $updateQuery .= " WHERE id = ?";
                    $updateParams[] = $userId;
                    
                    $stmtUpdate = $pdo->prepare($updateQuery);
                    $stmtUpdate->execute($updateParams);
                    
                    $_SESSION['user']['username'] = $newUsername;
                    $_SESSION['user']['email'] = $newEmail;
                    
                    if ($profilePicturePath === 'DELETE') {
                        $_SESSION['user']['profile_picture'] = null;
                        // Reload $user early to clear UI too
                        $user['profile_picture'] = null; 
                    } elseif ($profilePicturePath) {
                        $_SESSION['user']['profile_picture'] = $profilePicturePath;
                    }
                    
                    $success_msg = "Vos informations ont été mises à jour avec succès.";
                }
            } catch (PDOException $e) {
                $error_msg = "Erreur lors de la mise à jour.";
            }
        }
    } elseif ($uploadOk) {
        $error_msg = "Veuillez remplir tous les champs.";
    }
} elseif (!$isPublicProfile && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_balance') {
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
    // Récupérer les informations de l'utilisateur concerné
    $stmtUser = $pdo->prepare("SELECT * FROM User WHERE id = ?");
    $stmtUser->execute([$userId]);
    $user = $stmtUser->fetch();

    if ($user && !$isPublicProfile) {
        $_SESSION['user']['balance'] = $user['balance']; // Mettre à jour la session
    }

    if (!$user) {
        // Rediriger vers l'accueil si l'utilisateur n'existe pas
        header('Location: index.php');
        exit;
    }

    // Récupérer les factures uniquement si c'est le compte de l'utilisateur
    if (!$isPublicProfile) {
        $stmtInv = $pdo->prepare("SELECT * FROM Invoice WHERE user_id = ? ORDER BY transaction_date DESC");
        $stmtInv->execute([$userId]);
        $invoices = $stmtInv->fetchAll();
    }

    // Récupérer les articles (pour la vente ou publiés)
    $stmtMyArt = $pdo->prepare("SELECT a.*, s.quantity FROM Article a LEFT JOIN Stock s ON a.id = s.article_id WHERE a.author_id = ? ORDER BY a.id DESC");
    $stmtMyArt->execute([$userId]);
    $myArticles = $stmtMyArt->fetchAll();

} catch (PDOException $e) {
    // Silent error
}
