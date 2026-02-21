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