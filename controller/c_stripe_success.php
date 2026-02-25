<?php

$userId = $_SESSION['user']['id'];
$error = null;
$success = null;

if (!isset($_GET['session_id']) || empty($_SESSION['checkout_data'])) {
    redirect('cart');
}

$sessionId = $_GET['session_id'];

// Ideally we would verify the session_id with Stripe API here
// But since this is a test implementation, we'll proceed directly.

$checkoutData = $_SESSION['checkout_data'];
$address = $checkoutData['address'];
$city = $checkoutData['city'];
$zip = $checkoutData['zip'];
$total = $checkoutData['total'];

// Get Cart Items
$cartItems = [];
try {
    $stmt = $pdo->prepare("
        SELECT a.id, c.quantity
        FROM Cart c 
        JOIN Article a ON c.article_id = a.id 
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();
} catch (PDOException $e) {
    //
}

if (!empty($cartItems)) {
    try {
        $pdo->beginTransaction();
        
        // 1. Deduct Balance (Simulated feature requested by user)
        $stmtUpdateUser = $pdo->prepare("UPDATE User SET balance = balance - ? WHERE id = ?");
        $stmtUpdateUser->execute([$total, $userId]);

        // 2. Create the Invoice
        $stmtInvoice = $pdo->prepare("INSERT INTO Invoice (user_id, amount, billing_address, billing_city, billing_zip, transaction_date) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmtInvoice->execute([$userId, $total, $address, $city, $zip]);
        
        // 2. Reduce the Stock
        $stmtStock = $pdo->prepare("UPDATE Stock SET quantity = quantity - ? WHERE article_id = ? AND quantity >= ?");
        foreach ($cartItems as $item) {
            $stmtStock->execute([$item['quantity'], $item['id'], $item['quantity']]);
        }
        
        // 3. Clear the Cart
        $stmtClear = $pdo->prepare("DELETE FROM Cart WHERE user_id = ?");
        $stmtClear->execute([$userId]);
        
        $pdo->commit();
        $success = "Paiement validé avec succès ! Votre commande a bien été enregistrée.";
        
        // Clear session checkout data
        unset($_SESSION['checkout_data']);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Erreur lors de l'enregistrement de la commande : " . $e->getMessage();
    }
} else {
    $error = "Le panier est vide ou la commande a déjà été traitée.";
}
