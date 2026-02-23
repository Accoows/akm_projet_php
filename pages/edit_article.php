<div class="container">
    <h2 class="section-title"><i class="fa-solid fa-pen"></i> Modifier l'article</h2>

    <div class="auth-container dark-form glass-card" style="max-width: 600px; margin: 0 auto; padding: 30px;">
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
            <a href="detail&id=<?= $article['id'] ?>" class="btn-primary" style="display:inline-block; margin-bottom: 20px;">Voir l'article</a>
        <?php endif; ?>

        <form action="edit_article&id=<?= $article['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nom de l'article</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-tag"></i>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($article['name']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <div class="input-wrapper" style="align-items: flex-start;">
                    <i class="fa-solid fa-align-left" style="margin-top: 15px;"></i>
                    <textarea id="description" name="description" rows="5" required style="width: 100%; padding: 15px 15px 15px 45px; background: rgba(10,10,10,0.5); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; transition: 0.3s; outline: none; resize: vertical;"><?= htmlspecialchars($article['description']) ?></textarea>
                </div>
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label for="price">Prix (€)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-euro-sign"></i>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="<?= htmlspecialchars($article['price']) ?>" required>
                    </div>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="quantity">Quantité en stock</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <input type="number" step="1" min="0" id="quantity" name="quantity" value="<?= htmlspecialchars($article['quantity']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Image actuelle</label>
                <?php if (!empty($article['image_link'])): ?>
                    <img src="<?= htmlspecialchars($article['image_link']) ?>" alt="Image" style="max-width: 150px; display: block; margin-bottom: 10px; border-radius: 8px;">
                <?php endif; ?>
                <label for="image">Nouvelle Image (Optionnelle, max 5Mo)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" style="color: #ccc; background: rgba(10,10,10,0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 10px 10px 10px 45px; width: 100%;">
                </div>
            </div>

            <button type="submit" name="edit_btn" class="btn-primary btn-full-width btn-glow" style="margin-top: 20px;">
                <i class="fa-solid fa-save"></i> Mettre à jour l'article
            </button>
            
            <a href="detail&id=<?= $article['id'] ?>" class="btn-secondary btn-full-width" style="margin-top: 10px; text-align: center;">
                Annuler
            </a>
        </form>
    </div>
</div>
