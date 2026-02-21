<section class="banner hero-banner">
    <div class="banner-content">
        <h1>L'excellence à votre portée</h1>
        <p>Découvrez notre sélection exclusive 2025.</p>
    </div>
</section>

<?php
require_once 'config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM article ORDER BY publication_date DESC LIMIT 4");
    $latestArticles = $stmt->fetchAll();
} catch (PDOException $e) {
    $latestArticles = [];
}
?>

<section class="grid-articles">
    <?php foreach ($latestArticles as $article): ?>
        <div class="article-box">
            <div class="article-image">
                <?php if (!empty($article['image_link'])): ?>
                    <img src="<?= htmlspecialchars($article['image_link']) ?>" alt="<?= htmlspecialchars($article['name']) ?>">
                <?php else: ?>
                    <i class="fa-solid fa-image"></i>
                <?php endif; ?>
            </div>
            <span><?= htmlspecialchars($article['name']) ?></span>
            <br>
            <small><?= number_format($article['price'], 2) ?> €</small>
        </div>
    <?php endforeach; ?>
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
        <p>Depuis des années, nous nous efforçons de proposer des solutions innovantes pour nos clients. Notre expertise
            et notre passion nous permettent de rester à la pointe de l'industrie.</p>
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