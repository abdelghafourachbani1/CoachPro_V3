<?php $pageTitle = 'Modifier une Séance'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Modifier la Séance</h1>

<form action="/CoachPro_V3/public/index.php?url=coach/editSeance&id=<?= $seance['id'] ?>" method="POST" class="form">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($seance['titre']) ?>" required>
    </div>
    
    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($seance['description']) ?></textarea>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label for="date_seance">Date</label>
            <input type="date" id="date_seance" name="date_seance" value="<?= htmlspecialchars($seance['date_seance']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="places_disponibles">Places disponibles</label>
<input type="number" id="places_disponibles" name="places_disponibles" value="<?= htmlspecialchars($seance['places_disponibles']) ?>" min="1" required>
</div>
</div>
<div class="form-row">
    <div class="form-group">
        <label for="heure_debut">Heure de début</label>
        <input type="time" id="heure_debut" name="heure_debut" value="<?= htmlspecialchars($seance['heure_debut']) ?>" required>
    </div>
    
    <div class="form-group">
        <label for="heure_fin">Heure de fin</label>
        <input type="time" id="heure_fin" name="heure_fin" value="<?= htmlspecialchars($seance['heure_fin']) ?>" required>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="/CoachPro_V3/public/index.php?url=coach/seances" class="btn btn-secondary">Annuler</a>
</div>
</form>
<?php include __DIR__ . '/../partials/footer.php'; ?>