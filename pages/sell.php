<?php
// pages/sell.php
require_once 'config/database.php';

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo "<script>window.location.replace('login');</script>";
    exit();
}

$error = null;
$success = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sell_btn'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    
    // Gestion de l'image
    $imagePath = 'assets/images/bg1.png'; // Défaut
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $filetype = $_FILES['image']['type'];
        $filesize = $_FILES['image']['size'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            if ($filesize < 5 * 1024 * 1024) { // 5MB max
                $newFilename = uniqid() . '.' . $ext;
                $uploadDir = 'assets/images/uploads/';
                
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
                $pdo->beginTransaction();
                
                // Insertion Article
                $stmt = $pdo->prepare("INSERT INTO Article (name, description, price, author_id, image_link, publication_date) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$name, $description, $price, $_SESSION['user']['id'], $imagePath]);
                $articleId = $pdo->lastInsertId();
                
                // Insertion Stock
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
?>

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
                    <input type="text" id="name" name="name" required placeholder="Ex: Gilet Tactique JPC" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="price">Prix (€) *</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required placeholder="0.00" value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>">
                    </div>
                    <div class="form-group half">
                        <label for="quantity">Quantité *</label>
                        <input type="number" id="quantity" name="quantity" min="1" required placeholder="1" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '1' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5" placeholder="Détails du produit, état, caractéristiques..."><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
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