
<?php $pageTitle = 'Inscription'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Inscription</h1>
        
        <?php 
        $errors = Session::get('errors', []);
        $old = Session::get('old', []);
        Session::delete('errors');
        Session::delete('old');
        ?>
        
        <?php if ($error = Session::getFlash('error')): ?>
            <div class="alert alert-error"><?= Security::escape($error) ?></div>
        <?php endif; ?>
        
        <form action="/CoachPro_V3/public/index.php?url=auth/doRegister" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="role">Je suis :</label>
                <select id="role" name="role" onchange="toggleCoachFields()">
                    <option value="sportif" <?= ($old['role'] ?? 'sportif') === 'sportif' ? 'selected' : '' ?>>Sportif</option>
                    <option value="coach" <?= ($old['role'] ?? '') === 'coach' ? 'selected' : '' ?>>Coach</option>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" value="<?= Security::escape($old['nom'] ?? '') ?>" required>
                    <?php if (isset($errors['nom'])): ?>
                        <span class="error-message"><?= $errors['nom'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" value="<?= Security::escape($old['prenom'] ?? '') ?>" required>
                    <?php if (isset($errors['prenom'])): ?>
                        <span class="error-message"><?= $errors['prenom'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= Security::escape($old['email'] ?? '') ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <span class="error-message"><?= $errors['email'] ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe * (min. 6 caractères)</label>
                <input type="password" id="password" name="password" required minlength="6">
                <?php if (isset($errors['password'])): ?>
                    <span class="error-message"><?= $errors['password'] ?></span>
                <?php endif; ?>
            </div>
            
            <!-- Champs Sportif -->
            <div id="sportif-fields" style="display: <?= ($old['role'] ?? 'sportif') === 'sportif' ? 'block' : 'none' ?>">
                <div class="form-group">
                    <label for="niveau">Niveau</label>
                    <select id="niveau" name="niveau">
                        <option value="Débutant" <?= ($old['niveau'] ?? 'Débutant') === 'Débutant' ? 'selected' : '' ?>>Débutant</option>
                        <option value="Intermédiaire" <?= ($old['niveau'] ?? '') === 'Intermédiaire' ? 'selected' : '' ?>>Intermédiaire</option>
                        <option value="Avancé" <?= ($old['niveau'] ?? '') === 'Avancé' ? 'selected' : '' ?>>Avancé</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="objectifs">Objectifs</label>
                    <textarea id="objectifs" name="objectifs" rows="3"><?= Security::escape($old['objectifs'] ?? '') ?></textarea>
                </div>
            </div>
            
            <!-- Champs Coach -->
            <div id="coach-fields" style="display: <?= ($old['role'] ?? '') === 'coach' ? 'block' : 'none' ?>">
                <div class="form-group">
                    <label for="specialites">Spécialités *</label>
                    <input type="text" id="specialites" name="specialites" value="<?= Security::escape($old['specialites'] ?? '') ?>" placeholder="Ex: Yoga, Fitness">
                    <?php if (isset($errors['specialites'])): ?>
                        <span class="error-message"><?= $errors['specialites'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="experience">Années d'expérience</label>
                    <input type="number" id="experience" name="experience" value="<?= Security::escape($old['experience'] ?? '0') ?>" min="0">
                </div>
                
                <div class="form-group">
                    <label for="description">Description * (min. 20 caractères)</label>
                    <textarea id="description" name="description" rows="3"><?= Security::escape($old['description'] ?? '') ?></textarea>
                    <?php if (isset($errors['description'])): ?>
                        <span class="error-message"><?= $errors['description'] ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="tarif_horaire">Tarif horaire (€) *</label>
                    <input type="number" id="tarif_horaire" name="tarif_horaire" value="<?= Security::escape($old['tarif_horaire'] ?? '0') ?>" step="0.01" min="0">
                    <?php if (isset($errors['tarif_horaire'])): ?>
                        <span class="error-message"><?= $errors['tarif_horaire'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>
        
        <p class="text-center mt-3">
            Déjà un compte ? <a href="/CoachPro_V3/public/index.php?url=auth/login">Se connecter</a>
        </p>
    </div>
</div>

<script>
function toggleCoachFields() {
    const role = document.getElementById('role').value;
    const sportifFields = document.getElementById('sportif-fields');
    const coachFields = document.getElementById('coach-fields');
    
    if (role === 'coach') {
        sportifFields.style.display = 'none';
        coachFields.style.display = 'block';
    } else {
        sportifFields.style.display = 'block';
        coachFields.style.display = 'none';
    }
}
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>

