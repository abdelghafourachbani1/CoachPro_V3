<?php $pageTitle = 'Accueil - Sport MVC'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="hero">
    <h1>Bienvenue sur Sport MVC</h1>
    <p>Trouvez votre coach sportif idéal et réservez vos séances en quelques clics</p>
    
    <?php if (!Session::isAuthenticated()): ?>
        <div class="hero-buttons">
            <a href="/CoachPro_V3/public/index.php?url=auth/register" class="btn btn-primary">S'inscrire</a>
            <a href="/CoachPro_V3/public/index.php?url=auth/login" class="btn btn-secondary">Se connecter</a>
        </div>
    <?php endif; ?>
</div>

<div class="features">
    <div class="feature-card">
        <h3>🏋️ Coachs Professionnels</h3>
        <p>Trouvez des coachs certifiés et expérimentés dans diverses disciplines sportives.</p>
    </div>
    
    <div class="feature-card">
        <h3>📅 Réservation Simple</h3>
        <p>Réservez vos séances en ligne en quelques clics et gérez votre emploi du temps facilement.</p>
    </div>
    
    <div class="feature-card">
        <h3>💪 Suivi Personnalisé</h3>
        <p>Bénéficiez d'un accompagnement adapté à vos objectifs et à votre niveau.</p>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
