<?php $pageTitle = 'Ajouter une Séance'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Ajouter une Séance</h1>

<?php 
$errors = Session::get('errors', []);
$old = Session::get('old', []);
Session::delete('errors');
Session::delete('old');
?>

<form action="/CoachPro_V3/public/index.php?url=coach/addSeance" method="POST" class="form">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    
    <div class="form-group">
        <label for="titre">Titre *</label>
        <input type="text" id="titre" name="titre" value="<?= Security::escape($old['titre'] ?? '') ?>" required>
        <?php if (isset($errors['titre'])): ?>
            <span class="error-message"><?= $errors['titre'] ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="description">Description *</label>
        <textarea id="description" name="description" rows="4" required><?= Security::escape($old['description'] ?? '') ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <span class="error-message"><?= $errors['description'] ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="date_seance">Date *</label>
            <input type="date" id="date_seance" name="date_seance" value="<?= Security::escape($old['date_seance'] ?? '') ?>" required>
            <?php if (isset($errors['date_seance'])): ?>
                <span class="error-message"><?= $errors['date_seance'] ?></span>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="places_disponibles">Places disponibles *</label>
            <input type="number" id="places_disponibles" name="places_disponibles" value="<?= Security::escape($old['places_disponibles'] ?? '10') ?>" min="1" required>
            <?php if (isset($errors['places_disponibles'])): ?>
                <span class="error-message"><?= $errors['places_disponibles'] ?></span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="heure_debut">Heure de début *</label>
            <input type="time" id="heure_debut" name="heure_debut" value="<?= Security::escape($old['heure_debut'] ?? '') ?>" required>
            <?php if (isset($errors['heure_debut'])): ?>
                <span class="error-message"><?= $errors['heure_debut'] ?></span>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="heure_fin">Heure de fin *</label>
            <input type="time" id="heure_fin" name="heure_fin" value="<?= Security::escape($old['heure_fin'] ?? '') ?>" required>
            <?php if (isset($errors['heure_fin'])): ?>
                <span class="error-message"><?= $errors['heure_fin'] ?></span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Créer la séance</button>
        <a href="/CoachPro_V3/public/index.php?url=coach/seances" class="btn btn-secondary">Annuler</a>
    </div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>