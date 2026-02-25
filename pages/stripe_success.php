<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-check-circle" style="color: var(--success-color);"></i> Paiement réussi
    </h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            <br><br>
            <a href="account" class="btn-primary">Voir mon compte</a>
        </div>
    <?php elseif ($error): ?>
        <div class="alert alert-error">
            <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?>
            <br><br>
            <a href="cart" class="btn-secondary">Retour au panier</a>
        </div>
    <?php endif; ?>
</div>
