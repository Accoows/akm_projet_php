<?php


$userId = $_SESSION['user']['id'];
$error = null;
$success = null;


try {
    $stmt = $pdo->prepare("
        SELECT a.id, a.price, a.name, c.quantity
        FROM Cart c 
        JOIN Article a ON c.article_id = a.id 
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();
} catch (PDOException $e) {
    $cartItems = [];
}

$totalHT = 0;
foreach ($cartItems as $item) {
    $totalHT += $item['price'] * $item['quantity'];
}
$totalTTC = $totalHT * 1.20;
$total = $totalTTC; 


if (isPost()) {
    $address = sanitize($_POST['address']);
    $city = sanitize($_POST['city']);
    $zip = sanitize($_POST['zip']);

    if (empty($cartItems)) {
        $error = "Votre panier est vide.";
    } elseif ($total > $_SESSION['user']['balance']) {
        // Balance check requested by user
        $stmtBalance = $pdo->prepare("SELECT balance FROM User WHERE id = ?");
        $stmtBalance->execute([$userId]);
        $currentBalance = $stmtBalance->fetchColumn();

        if ($total > $currentBalance) {
            $error = "Solde insuffisant. Votre solde actuel est de " . number_format($currentBalance, 2) . " €.";
        }
    }

    
    if (!$error && !empty($address) && !empty($city) && !empty($zip)) {
        $_SESSION['checkout_data'] = [
            'address' => $address,
            'city' => $city,
            'zip' => $zip,
            'total' => $total
        ];

        
        $envPath = __DIR__ . '/../.env';
        $env = parse_ini_file($envPath);
        $stripeSecretKey = isset($env['STRIPE_SECRET_KEY']) ? $env['STRIPE_SECRET_KEY'] : '';

        if (empty($stripeSecretKey) || strpos($stripeSecretKey, 'sk_test_') === false) {
            $error = "Configuration Stripe manquante. Veuillez ajouter votre clé Stripe Secrète (sk_test_...) dans le fichier .env.";
        } else {
            $line_items = [];
            foreach ($cartItems as $i => $item) {
                $line_items['line_items['.$i.'][price_data][currency]'] = 'eur';
                $line_items['line_items['.$i.'][price_data][product_data][name]'] = $item['name'];
                $line_items['line_items['.$i.'][price_data][unit_amount]'] = round($item['price'] * 1.20 * 100);
                $line_items['line_items['.$i.'][quantity]'] = $item['quantity'];
            }

            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $base_dir = rtrim(dirname($_SERVER['PHP_SELF']), '/\\\\');
            $base_url = $protocol . '://' . $host . $base_dir;

            $stripeData = array_merge([
                'payment_method_types[0]' => 'card',
                'mode' => 'payment',
                'success_url' => $success_url = $base_url . '/index.php?page=stripe_success&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $base_url . '/index.php?page=cart_validation',
            ], $line_items);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/checkout/sessions");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($stripeData));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Important pour WAMP en local
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $stripeSecretKey",
                "Content-Type: application/x-www-form-urlencoded"
            ]);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);

            if ($http_code === 200) {
                $responseData = json_decode($response, true);
                if (isset($responseData['url'])) {
                    header("Location: " . $responseData['url']);
                    exit();
                } else {
                    $error = "Erreur de réponse Stripe.";
                }
            } else {
                $responseData = json_decode($response, true);
                $errorMsg = isset($responseData['error']['message']) ? $responseData['error']['message'] : ($curl_error ? $curl_error : 'Erreur inconnue');
                $error = "Erreur avec l'API Stripe ($http_code) : " . $errorMsg;
            }
        }
    } elseif (!$error) {
        $error = "Veuillez remplir l'adresse de livraison.";
    }
}
