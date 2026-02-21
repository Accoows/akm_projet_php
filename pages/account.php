<?php
// pages/account.php
require_once 'config/database.php';

if (!isset($_SESSION['user'])) {
    echo "<script>window.location.replace('login');</script>";
    exit();
}

$userId = $_SESSION['user']['id'];
$user = [];
$invoices = [];

try {
    // 1. Récupérer infos utilisateur à jour
    $stmtUser = $pdo->prepare("SELECT * FROM User WHERE id = ?");
    $stmtUser->execute([$userId]);
    $user = $stmtUser->fetch();
    
    // Mettre à jour la session si besoin
    if ($user) {
        $_SESSION['user']['balance'] = $user['balance']; // On suppose que la clé existe ou on l'ajoute
    }

    // 2. Récupérer l'historique des commandes
    $stmtInv = $pdo->prepare("SELECT * FROM Invoice WHERE user_id = ? ORDER BY transaction_date DESC");
    $stmtInv->execute([$userId]);
    $invoices = $stmtInv->fetchAll();

} catch (PDOException $e) {
    // Silent error
}
?>

<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-user-shield"></i> Mon Espace Personnel
    </h2>

    <div class="account-grid">
        <!-- Profil -->
        <div class="account-card profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                   <?php 
                        $avatar = !empty($user['profile_picture']) ? $user['profile_picture'] : 'assets/images/placeholder_user.png';
                   ?>
                   <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar">
                </div>
                <h3><?= htmlspecialchars($user['username']) ?></h3>
                <span class="user-role"><?= htmlspecialchars($user['role']) ?></span>
            </div>
            
            <div class="profile-details">
                <div class="detail-row">
                    <span class="label">Email :</span>
                    <span class="value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="label">Solde :</span>
                    <span class="value balance"><?= number_format($user['balance'], 2) ?> €</span>
                </div>
                <!-- Bouton Recharger (fictif pour l'instant) -->
                <button class="btn-secondary btn-small" onclick="alert('Fonctionnalité de rechargement bientôt disponible !')">
                    <i class="fa-solid fa-wallet"></i> Recharger
                </button>
            </div>
        </div>

        <!-- Historique Commandes -->
        <div class="account-card history-card">
            <h3><i class="fa-solid fa-clock-rotate-left"></i> Historique des commandes</h3>
            
            <?php if (empty($invoices)): ?>
                <p>Aucune commande effectuée pour le moment.</p>
            <?php else: ?>
                <div class="table-scroll">
                    <table class="table-dark">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Lieu</th>
                                <th>Ref</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoices as $inv): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($inv['transaction_date'])) ?></td>
                                    <td><?= number_format($inv['amount'], 2) ?> €</td>
                                    <td><?= htmlspecialchars($inv['billing_city']) ?></td>
                                    <td>#<?= $inv['id'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>