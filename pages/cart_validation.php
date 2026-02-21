<?php
// pages/cart_validation.php
require_once 'config/database.php';

if (!isset($_SESSION['user'])) {
    header('Location: login');
    exit();
}

$userId = $_SESSION['user']['id'];
$error = null;
$success = null;

// 1. Récupérer le panier
try {
    $stmt = $pdo->prepare("
        SELECT a.id, a.price, a.name 
        FROM Cart c 
        JOIN Article a ON c.article_id = a.id 
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();
} catch (PDOException $e) {
    $cartItems = [];
}

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'];
}

// 2. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $zip = trim($_POST['zip']);

    if (empty($cartItems)) {
        $error = "Votre panier est vide.";
    } elseif ($total > $_SESSION['user']['balance']) { // (Si on avait mis à jour la session avec le solde réel)
        // Note: Idéalement il faut rafraîchir le solde depuis la DB avant
        $stmtBalance = $pdo->prepare("SELECT balance FROM User WHERE id = ?");
        $stmtBalance->execute([$userId]);
        $currentBalance = $stmtBalance->fetchColumn();

        if ($total > $currentBalance) {
            $error = "Solde insuffisant. Votre solde actuel est de " . number_format($currentBalance, 2) . " €.";
        }
    }

    // Si pas d'erreur de solde (ou vérification faite ci-dessus), on procède
    if (!$error && !empty($address) && !empty($city) && !empty($zip)) {
        try {
            $pdo->beginTransaction();

            // 1. Débiter l'utilisateur
            $stmtUpdateUser = $pdo->prepare("UPDATE User SET balance = balance - ? WHERE id = ?");
            $stmtUpdateUser->execute([$total, $userId]);

            // 2. Créer la facture
            $fullAddress = $address . ', ' . $zip . ' ' . $city;
            $stmtInvoice = $pdo->prepare("INSERT INTO Invoice (user_id, amount, billing_address, billing_city, billing_zip, transaction_date) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmtInvoice->execute([$userId, $total, $address, $city, $zip]);

            // 3. Mettre à jour les stocks
            $stmtStock = $pdo->prepare("UPDATE Stock SET quantity = quantity - 1 WHERE article_id = ? AND quantity > 0");
            foreach ($cartItems as $item) {
                $stmtStock->execute([$item['id']]);
            }

            // 4. Vider le panier
            $stmtClear = $pdo->prepare("DELETE FROM Cart WHERE user_id = ?");
            $stmtClear->execute([$userId]);

            $pdo->commit();
            $success = "Commande validée avec succès !";
            // Mise à jour session solde pour affichage immédiat
            // (Simplification, idéalement re-fetch user)

        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erreur lors de la validation : " . $e->getMessage();
        }
    } elseif (!$error) {
        $error = "Veuillez remplir l'adresse de livraison.";
    }
}
?>

<div class="container">
    <h2 class="section-title">
        <i class="fa-solid fa-truck-fast"></i> Validation de la commande
    </h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            <br><br>
            <a href="account" class="btn-primary">Voir mon compte</a>
        </div>
    <?php else: ?>

        <div class="checkout-container">
            <!-- Left: Shipping Form -->
            <div class="checkout-form dark-form">
                <h3><i class="fa-solid fa-location-dot"></i> Adresse de livraison</h3>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="cart_validation" method="POST" id="checkout-form">
                    <div class="form-group">
                        <label for="fullname">Nom complet</label>
                        <input type="text" id="fullname" name="fullname" placeholder="John Doe" required
                            value="<?= htmlspecialchars($_SESSION['user']['username']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" id="address" name="address" placeholder="123 Rue de la Base" required>
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" id="city" name="city" placeholder="Paris" required>
                    </div>

                    <div class="form-group">
                        <label for="zip">Code Postal</label>
                        <input type="text" id="zip" name="zip" placeholder="75000" required>
                    </div>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="checkout-summary">
                <h3><i class="fa-solid fa-file-invoice-dollar"></i> Récapitulatif</h3>

                <div class="summary-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="summary-item">
                            <span><?= htmlspecialchars($item['name']) ?></span>
                            <span><?= number_format($item['price'], 2) ?> €</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-total">
                    <span>Total à payer</span>
                    <span><?= number_format($total, 2) ?> €</span>
                </div>

                <?php if (!empty($cartItems)): ?>
                    <button type="submit" form="checkout-form" class="btn-primary btn-full-width">
                        <i class="fa-solid fa-lock"></i> Confirmer et Payer
                    </button>
                <?php endif; ?>
                <br>
                <a href="cart" class="btn-secondary btn-full-width">
                    Retour au panier
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>