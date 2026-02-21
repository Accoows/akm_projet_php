<?php
// pages/admin/articles.php
require_once 'config/database.php';

$articles = [];
try {
    $stmt = $pdo->query("SELECT a.*, s.quantity FROM Article a LEFT JOIN Stock s ON a.id = s.article_id ORDER BY a.id DESC");
    $articles = $stmt->fetchAll();
} catch (PDOException $e) {
    $articles = [];
}
?>

<div class="container">
    <div class="admin-header">
        <h2 class="section-title"><i class="fa-solid fa-boxes-stacked"></i> Gestion des Articles</h2>
        <a href="admin" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i> Retour Dashboard</a>
    </div>

    <div class="table-scroll">
        <table class="table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td>
                            <?php if (!empty($a['image_link'])): ?>
                                <img src="<?= htmlspecialchars($a['image_link']) ?>" class="admin-article-img">
                            <?php else: ?>
                                <i class="fa-solid fa-image"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($a['name']) ?></td>
                        <td><?= number_format($a['price'], 2) ?> €</td>
                        <td><?= $a['quantity'] ?? 0 ?></td>
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