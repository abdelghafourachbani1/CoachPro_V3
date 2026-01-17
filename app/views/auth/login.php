<?php $pageTitle = 'Connexion'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Connexion</h1>
        
        <?php 
        $errors = Session::get('errors', []);
        $old = Session::get('old', []);
        Session::delete('errors');
        Session::delete('old');
        ?>
        
        <?php if ($error = Session::getFlash('error')): ?>
            <div class="alert alert-error"><?= Security::escape($error) ?></div>
        <?php endif; ?>
        
        <form action="/CoachPro_V3/public/index.php?url=auth/doLogin" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= Security::escape($old['email'] ?? '') ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <span class="error-message"><?= $errors['email'] ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])): ?>
                    <span class="error-message"><?= $errors['password'] ?></span>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        
        <p class="text-center mt-3">
            Pas de compte ? <a href="/CoachPro_V3/public/index.php?url=auth/register">S'inscrire</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>