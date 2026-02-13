<?php 
// On imagine que le header et footer sont inclus via le controller principal 
// ou directement ici si tu travailles sur le fichier brut.
include_once 'includes/header.php';
?>

<main class="container">
    <section class="banner hero-banner">
        <div class="banner-content">
            <h1>L'excellence à votre portée</h1>
            <p>Découvrez notre sélection exclusive 2025.</p>
        </div>
    </section>

    <section class="grid-articles">
        <div class="article-box"><span>Article 1</span></div>
        <div class="article-box"><span>Article 2</span></div>
        <div class="article-box"><span>Article 3</span></div>
        <div class="article-box"><span>Article 4</span></div>
    </section>

    <section class="banner mid-banner">
        <h2>Nouvelle Collection</h2>
    </section>

    <section class="grid-articles">
        <div class="article-box"><span>Article 5</span></div>
        <div class="article-box"><span>Article 6</span></div>
        <div class="article-box"><span>Article 7</span></div>
        <div class="article-box"><span>Article 8</span></div>
    </section>

    <section class="about-section">
        <div class="about-text">
            <h3>Notre Engagement</h3>
            <p>Depuis des années, nous nous efforçons de proposer des solutions innovantes pour nos clients. Notre expertise et notre passion nous permettent de rester à la pointe de l'industrie.</p>
        </div>
        <div class="about-image">
            <div class="img-placeholder">IMAGE ENTREPRISE</div>
        </div>
    </section>

    <section class="banner mini-banner">
        <h4>Quelques avis</h4>
    </section>

    <section class="grid-reviews">
        <div class="review-card">
            <p>"Service impeccable, je recommande vivement."</p>
            <small>- Jean D.</small>
        </div>
        <div class="review-card">
            <p>"Qualité au rendez-vous et design moderne."</p>
            <small>- Sophie L.</small>
        </div>
        <div class="review-card">
            <p>"Une équipe à l'écoute de nos besoins."</p>
            <small>- Marc A.</small>
        </div>
    </section>
</main>

<?php include_once '../includes/footer.php'; ?>