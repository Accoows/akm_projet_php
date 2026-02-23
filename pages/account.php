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
                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success profile-alert">
                        <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success_msg) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-error profile-alert">
                        <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error_msg) ?>
                    </div>
                <?php endif; ?>

                <div id="profile-info">
                    <div class="detail-row">
                        <span class="label">Email :</span>
                        <span class="value"><?= htmlspecialchars($user['email']) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Solde :</span>
                        <span class="value balance"><?= number_format($user['balance'], 2) ?> €</span>
                    </div>

                    <div class="profile-actions">
                        <button class="btn-primary btn-small" id="btn-edit-profile">
                            <i class="fa-solid fa-pen"></i> Modifier mes infos
                        </button>
                        <button class="btn-secondary btn-small" id="btn-add-balance">
                            <i class="fa-solid fa-wallet"></i> Recharger
                        </button>
                    </div>
                </div>

                <div id="balance-edit" class="hidden">
                    <form action="index.php?page=account" method="POST" class="auth-form profile-edit-form">
                        <input type="hidden" name="action" value="update_balance">
                        
                        <div class="form-group">
                            <label for="balance">Nouveau Solde (€)</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-coins"></i>
                                <input type="number" step="0.01" min="0" id="balance" name="balance" value="<?= htmlspecialchars($user['balance']) ?>" required>
                            </div>
                        </div>

                        <div class="profile-form-actions">
                            <button type="submit" class="btn-primary profile-form-btn">
                                <i class="fa-solid fa-check"></i> Valider
                            </button>
                            <button type="button" class="btn-secondary profile-form-btn" id="btn-cancel-balance">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>

                <div id="profile-edit" class="hidden">
                    <form action="index.php?page=account" method="POST" class="auth-form profile-edit-form">
                        <input type="hidden" name="action" value="edit_profile">
                        
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-id-badge"></i>
                                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                        </div>

                        <div class="profile-form-actions">
                            <button type="submit" class="btn-primary profile-form-btn">
                                <i class="fa-solid fa-save"></i> Enregistrer
                            </button>
                            <button type="button" class="btn-secondary profile-form-btn" id="btn-cancel-edit">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
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