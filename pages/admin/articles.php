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
                            <a href="edit_article&id=<?= $a['id'] ?>" class="btn-small btn-secondary"><i class="fa-solid fa-pen"></i></a>
                            <a href="admin&sub=articles&action=delete&id=<?= $a['id'] ?>" class="btn-small btn-danger"
                                onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>