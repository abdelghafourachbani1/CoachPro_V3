<?php $pageTitle = 'Connexion'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Connexion</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/sport-mvc/public/index.php?url=auth/doLogin" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>

        <p class="text-center mt-3">
            Pas de compte ? <a href="/sport-mvc/public/index.php?url=auth/register">S'inscrire</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>