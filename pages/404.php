<?php 
// Définition du chemin pour remonter à la racine depuis le dossier /pages/
$path = "../"; 
include_once $path . 'includes/header.php'; 
?>

<main class="container error-page">
    <div class="error-card">
        <div class="error-icon">
            <i class="fa-solid fa- ghost"></i> <span>404</span>
        </div>
        
        <div class="error-content">
            <h1>Mission Interrompue</h1>
            <p>La page que vous recherchez est introuvable ou a été déplacée vers une zone sécurisée.</p>
            
            <a href="<?= $path ?>index.php" class="btn-error">
                <i class="fa-solid fa-house"></i> Retour à la base
            </a>
        </div>
    </div>
</main>

<?php include_once $path . 'includes/footer.php'; ?>