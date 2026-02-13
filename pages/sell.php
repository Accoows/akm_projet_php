<?php
// pages/sell.php
// Note : La logique de traitement PHP sera ajoutée plus tard.
?>

<div class="auth-container wide">
    <h2 class="section-title auth-title">
        <i class="fa-solid fa-tags"></i> Mettre en vente un article
    </h2>

    <p class="sell-intro">
        Remplissez les informations ci-dessous pour ajouter votre équipement au catalogue.
    </p>

    <div class="dark-form wide">
        <form action="sell" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Nom de l'article</label>
                <input type="text" id="name" name="name" required placeholder="Ex: Casque FAST Bump">
            </div>

            <div class="form-group">
                <label for="description">Description détaillée</label>
                <textarea id="description" name="description" rows="5"
                    placeholder="Décrivez les caractéristiques de votre article..."
                    placeholder="Décrivez les caractéristiques de votre article..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Prix (€)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required placeholder="0.00">
                </div>

                <div class="form-group">
                    <label for="quantity">Quantité en stock</label>
                    <input type="number" id="quantity" name="quantity" min="1" required placeholder="1">
                </div>
            </div>

            <div class="form-group">
                <label for="image">Image de l'article</label>
                <input type="file" id="image" name="image" accept="image/*" class="file-input">
                <small class="form-help">Format suggéré : JPG ou PNG. Poids max : 1Mo.</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="sell_btn" class="btn-primary btn-full-width">
                    <i class="fa-solid fa-plus-circle"></i> Publier l'annonce
                </button>
            </div>
        </form>
    </div>
</div>