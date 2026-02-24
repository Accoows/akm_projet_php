<div class="container">
    <div class="admin-header">
        <h2 class="section-title"><i class="fa-solid fa-file-invoice-dollar"></i> Gestion des Commandes</h2>
        <a href="admin" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i> Retour Dashboard</a>
    </div>

    <div class="table-scroll">
        <?php if (empty($orders)): ?>
            <p style="text-align: center; color: #888;">Aucune commande trouvée.</p>
        <?php else: ?>
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>ID Commande</th>
                        <th>Client</th>
                        <th>Date et Heure</th>
                        <th>Adresse de Facturation</th>
                        <th>Montant</th>
                        <!-- Action placeholder just in case -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td>#<?= $o['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars($o['username'] ?? 'Anonyme') ?></strong><br>
                                <span style="font-size: 0.85em; color: #888;"><?= htmlspecialchars($o['email'] ?? '') ?></span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($o['transaction_date'])) ?></td>
                            <td>
                                <?= htmlspecialchars($o['billing_address']) ?><br>
                                <span style="font-size: 0.85em; color: #888;"><?= htmlspecialchars($o['billing_city'] ?? '') ?> <?= htmlspecialchars($o['billing_zip'] ?? '') ?></span>
                            </td>
                            <td style="font-weight: bold; color: var(--bg-olive-light);"><?= number_format($o['amount'], 2) ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
