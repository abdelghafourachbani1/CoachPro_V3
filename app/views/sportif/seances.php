<?php $pageTitle = 'Séances Disponibles'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Séances Disponibles</h1>

<?php if ($success = Session::getFlash('success')): ?>
    <div class="alert alert-success"><?= Security::escape($success) ?></div>
<?php endif; ?>

<?php if ($error = Session::getFlash('error')): ?>
    <div class="alert alert-error"><?= Security::escape($error) ?></div>
<?php endif; ?>

<?php if (empty($seances)): ?>
    <p>Aucune séance disponible pour le moment.</p>
<?php else: ?>
    <div class="seances-grid">
        <?php foreach ($seances as $seance): ?>
            <div class="seance-card">
                <h3><?= Security::escape($seance['titre']) ?></h3>
                <p><strong>Coach:</strong> <?= Security::escape($seance['coach_prenom']) ?> <?= Security::escape($seance['coach_nom']) ?></p>
                <p><strong>Date:</strong> <?= Security::escape($seance['date_seance']) ?></p>
                <p><strong>Heure:</strong> <?= Security::escape($seance['heure_debut']) ?> - <?= Security::escape($seance['heure_fin']) ?></p>
                <p><strong>Places disponibles:</strong> <?= Security::escape($seance['places_disponibles']) ?></p>
                <p class="description"><?= Security::escape($seance['description']) ?></p>
                
                <?php if ($seance['places_disponibles'] > 0): ?>
                    <a href="/CoachPro_V3/public/index.php?url=sportif/reserver&seance_id=<?= $seance['id'] ?>&token=<?= Security::generateToken() ?>" 
                       class="btn btn-primary" 
                       onclick="return confirm('Confirmer la réservation ?')">Réserver</a>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled>Complet</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
```
