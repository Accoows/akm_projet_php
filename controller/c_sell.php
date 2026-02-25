<?php


$error = null;
$success = null;

if (isPost() && isset($_POST['sell_btn'])) {
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    // Set a default image if none is provided
    $imagePath = 'uploads/articles/bg1.png'; 

    // Handle image upload with validation
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $filetype = $_FILES['image']['type'];
        $filesize = $_FILES['image']['size'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if ($filesize < 5 * 1024 * 1024) { 
                $newFilename = uniqid() . '.' . $ext;
                $uploadDir = 'uploads/articles/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newFilename)) {
                    $imagePath = $uploadDir . $newFilename;
                } else {
                    $error = "Erreur lors du téléchargement de l'image.";
                }
            } else {
                $error = "L'image est trop volumineuse (max 5Mo).";
            }
        } else {
            $error = "Format de fichier non supporté.";
        }
    }

    if (!$error) {
        if (!empty($name) && $price > 0 && $quantity >= 0) {
            try {
                // Begin a transaction to ensure both Article and Stock are inserted atomically
                $pdo->beginTransaction();

                // Insert the new article
                $stmt = $pdo->prepare("INSERT INTO Article (name, description, price, author_id, image_link, publication_date) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$name, $description, $price, $_SESSION['user']['id'], $imagePath]);
                $articleId = $pdo->lastInsertId();

                // Insert the corresponding stock quantity
                $stmtStock = $pdo->prepare("INSERT INTO Stock (article_id, quantity) VALUES (?, ?)");
                $stmtStock->execute([$articleId, $quantity]);

                $pdo->commit();
                $success = "Votre article a été mis en vente avec succès !";
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Erreur lors de la mise en vente : " . $e->getMessage();
            }
        } else {
            $error = "Veuillez remplir correctement les champs obligatoires.";
        }
    }
}
