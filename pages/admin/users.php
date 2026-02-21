<?php
// pages/admin/users.php
require_once 'config/database.php';

$users = [];
try {
    $stmt = $pdo->query("SELECT * FROM User ORDER BY id DESC");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    $users = [];
}
?>

<div class="container">
    <div class="admin-header">
        <h2 class="section-title"><i class="fa-solid fa-users-gear"></i> Gestion des Utilisateurs</h2>
        <a href="admin" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i> Retour Dashboard</a>
    </div>

    <div class="table-scroll">
        <table class="table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Solde</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="badge <?= $u['role'] === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                <?= $u['role'] ?>
                            </span>
                        </td>
                        <td><?= number_format($u['balance'], 2) ?> €</td>
                        <td>
                            <button class="btn-small btn-danger" onclick="alert('Suppression désactivée pour la démo')"><i
                                    class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>