<div class="container">
    <h2 class="section-title"><i class="fa-solid fa-pen"></i> Modifier l'article</h2>

    <div class="auth-container dark-form glass-card form-card">
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
            <a href="detail&id=<?= $article['id'] ?>" class="btn-primary d-inline-block mb-20">Voir l'article</a>
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
                <div class="input-wrapper input-icon-align-top">
                    <i class="fa-solid fa-align-left icon-textarea"></i>
                    <textarea id="description" name="description" rows="5" required class="textarea-custom"><?= htmlspecialchars($article['description']) ?></textarea>
                </div>
            </div>

            <div class="form-row-flex">
                <div class="form-group form-item-flex">
                    <label for="price">Prix (€)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-euro-sign"></i>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="<?= htmlspecialchars($article['price']) ?>" required>
                    </div>
                </div>

                <div class="form-group form-item-flex">
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
                    <img src="<?= htmlspecialchars($article['image_link']) ?>" alt="Image" class="img-preview">
                <?php endif; ?>
                <label for="image">Nouvelle Image (Optionnelle, max 5Mo)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" class="input-file-custom">
                </div>
            </div>

            <button type="submit" name="edit_btn" class="btn-primary btn-full-width btn-glow mt-20">
                <i class="fa-solid fa-save"></i> Mettre à jour l'article
            </button>
            
            <a href="detail&id=<?= $article['id'] ?>" class="btn-secondary btn-full-width text-center mt-10">
                Annuler
            </a>
        </form>
    </div>
</div>
