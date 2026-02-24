<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-<?= $isPublicProfile ? 'user' : 'user-shield' ?>"></i> 
        <?= $isPublicProfile ? 'Profil de ' . htmlspecialchars($user['username']) : 'Mon Espace Personnel' ?>
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
                        <span class="value"><?= $isPublicProfile ? '<i class="fa-solid fa-lock text-muted-xs" title="Privé"></i> Privé' : htmlspecialchars($user['email']) ?></span>
                    </div>
                    <?php if (!$isPublicProfile): ?>
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
                    <?php endif; ?>
                </div>

                <?php if (!$isPublicProfile): ?>
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
                    <form action="index.php?page=account" method="POST" class="auth-form profile-edit-form" enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label for="profile_picture">Photo de profil (Optionnel)</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-image"></i>
                                <input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg, image/webp" class="input-file-custom profile-file-input">
                            </div>
                            <?php if (!empty($user['profile_picture'])): ?>
                                <div class="profile-delete-wrapper">
                                    <input type="checkbox" id="delete_picture" name="delete_picture" value="1" class="profile-delete-checkbox">
                                    <label for="delete_picture" class="profile-delete-label">Supprimer la photo actuelle</label>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Nouveau mot de passe</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="Laisser vide pour ne pas changer" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">Confirmer le mot de passe</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" id="password_confirm" name="password_confirm" placeholder="Laisser vide pour ne pas changer" autocomplete="new-password">
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
                <?php endif; ?>
            </div>
        </div>

        <!-- Historique Commandes -->
        <?php if (!$isPublicProfile): ?>
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
                                <th>Montant TTC</th>
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
        <?php endif; ?>

        <!-- Mes Articles en Vente -->
        <div class="account-card my-articles-card <?= $isPublicProfile ? 'grid-span-1' : 'grid-full-width' ?>">
            <h3><i class="fa-solid fa-box-open"></i> <?= $isPublicProfile ? 'Articles en vente' : 'Mes articles en vente' ?></h3>

            <?php if (empty($myArticles)): ?>
                <p><?= $isPublicProfile ? 'Cet utilisateur n\'a' : 'Vous n\'avez' ?> aucun article en vente.</p>
                <?php if (!$isPublicProfile): ?>
                <div class="mt-15">
                    <a href="sell" class="btn-primary btn-small">
                        <i class="fa-solid fa-plus"></i> Créer une annonce
                    </a>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (!$isPublicProfile): ?>
                <div class="mt-15 mb-15">
                    <a href="sell" class="btn-primary btn-small">
                        <i class="fa-solid fa-plus"></i> Créer une nouvelle annonce
                    </a>
                </div>
                <?php endif; ?>
                <div class="table-scroll">
                    <table class="table-dark">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <?php if (!$isPublicProfile): ?><th>Actions</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myArticles as $art): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($art['image_link'])): ?>
                                            <img src="<?= htmlspecialchars($art['image_link']) ?>" alt="Aperçu" class="account-article-img">
                                        <?php else: ?>
                                            <i class="fa-solid fa-image icon-large"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="detail&id=<?= $art['id'] ?>" class="text-link">
                                            <?= htmlspecialchars($art['name']) ?>
                                        </a>
                                    </td>
                                    <td class="balance"><?= number_format($art['price'], 2) ?> €</td>
                                    <td><?= (int)$art['quantity'] ?></td>
                                    <?php if (!$isPublicProfile): ?>
                                    <td>
                                        <div class="flex-actions">
                                            <a href="edit_article&id=<?= $art['id'] ?>" class="btn-secondary btn-small" title="Modifier">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="delete_article&id=<?= $art['id'] ?>" class="btn-secondary btn-small btn-danger" title="Supprimer" onclick="return confirm('Supprimer cet article ?');">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>