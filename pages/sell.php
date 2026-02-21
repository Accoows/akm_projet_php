<div class="container">
    <div class="sell-container">
        <h2 class="section-title">
            <i class="fa-solid fa-tag"></i> Vendre un article
        </h2>

        <div class="dark-form">
            <form action="sell" method="POST" enctype="multipart/form-data">

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i>
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="name">Nom du produit *</label>
                    <input type="text" id="name" name="name" required placeholder="Ex: Gilet Tactique JPC"
                        value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="price">Prix (€) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required placeholder="0.00"
                            value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>">
                    </div>
                    <div class="form-group half">
                        <label for="quantity">Quantité *</label>
                        <input type="number" id="quantity" name="quantity" min="1" required placeholder="1"
                            value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '1' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5"
                        placeholder="Détails du produit, état, caractéristiques..."><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Photo du produit</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" accept="image/*">
                        <small>Formats acceptés : JPG, PNG, WEBP. Max 5Mo.</small>
                    </div>
                </div>

                <button type="submit" name="sell_btn" class="btn-primary btn-full-width">
                    <i class="fa-solid fa-plus-circle"></i> Mettre en vente
                </button>

            </form>
        </div>
    </div>
</div>