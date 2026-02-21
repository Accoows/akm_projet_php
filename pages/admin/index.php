<?php
// pages/admin/index.php
require_once 'config/database.php';

// Check admin role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ./');
    exit();
}

$userCount = 0;
$articleCount = 0;
$orderCount = 0;

try {
    $userCount = $pdo->query("SELECT COUNT(*) FROM User")->fetchColumn();
    $articleCount = $pdo->query("SELECT COUNT(*) FROM Article")->fetchColumn();
    $orderCount = $pdo->query("SELECT COUNT(*) FROM Invoice")->fetchColumn();
} catch (PDOException $e) {
    // Silent error
}
?>

<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-gauge"></i> Tableau de bord Admin
    </h2>

    <div class="admin-stats-grid">
        <div class="stat-card">
            <i class="fa-solid fa-users"></i>
            <div class="stat-info">
                <h3>Utilisateurs</h3>
                <span class="stat-number"><?= $userCount ?></span>
            </div>
            <a href="admin&sub=users" class="stat-link">Gérer</a>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-boxes-stacked"></i>
            <div class="stat-info">
                <h3>Articles</h3>
                <span class="stat-number"><?= $articleCount ?></span>
            </div>
            <a href="admin&sub=articles" class="stat-link">Gérer</a>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <div class="stat-info">
                <h3>Commandes</h3>
                <span class="stat-number"><?= $orderCount ?></span>
            </div>
             <!-- Pas de page dédiée pour l'instant -->
             <span class="stat-link">Voir détails</span>
        </div>
    </div>
</div>

<style>
/* Simple CSS for admin dashboard added inline or could be in CSS file */
.admin-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}
.stat-card {
    background-color: #2c2c2c;
    padding: 20px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    border: 1px solid #444;
}
.stat-card i {
    font-size: 3rem;
    color: var(--bg-olive-light, #8d9e78);
    margin-bottom: 10px;
}
.stat-number {
    font-size: 2rem;
    font-weight: bold;
    display: block;
    margin: 10px 0;
}
.stat-link {
    margin-top: auto;
    color: #fff;
    text-decoration: underline;
    cursor: pointer;
}
</style>
