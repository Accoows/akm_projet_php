<div class="container">
    <h2 class="section-title"><i class="fa-solid fa-tag"></i> Vendre un article</h2>

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
        <?php endif; ?>

        <form action="sell" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nom du produit *</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-tag"></i>
                    <input type="text" id="name" name="name" required placeholder="Ex: Gilet Tactique JPC" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <div class="input-wrapper input-icon-align-top">
                    <i class="fa-solid fa-align-left icon-textarea"></i>
                    <textarea id="description" name="description" rows="5" placeholder="Détails du produit, état, caractéristiques..." class="textarea-custom"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                </div>
            </div>

            <div class="form-row-flex">
                <div class="form-group form-item-flex">
                    <label for="price">Prix (€) *</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-euro-sign"></i>
                        <input type="number" step="0.01" min="0" id="price" name="price" required placeholder="0.00" value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>">
                    </div>
                </div>

                <div class="form-group form-item-flex">
                    <label for="quantity">Quantité *</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <input type="number" step="1" min="0" id="quantity" name="quantity" required placeholder="1" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '1' ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Photo du produit</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-image"></i>
                    <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" class="input-file-custom">
                </div>
                <small class="text-muted-small">Formats acceptés : JPG, PNG, WEBP. Max 5Mo.</small>
            </div>

            <div class="form-group hidden" id="preview-container">
                <label>Aperçu de la nouvelle image</label>
                <img id="image-preview" src="" alt="Aperçu" class="img-preview">
            </div>

            <button type="submit" class="btn-primary btn-full-width">
                <i class="fa-solid fa-paper-plane"></i> Mettre en vente
            </button>
        </form>
    </div>
</div>