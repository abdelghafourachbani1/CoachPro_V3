<?php $pageTitle = 'Mes Séances'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="page-header">
    <h1>Mes Séances</h1>
    <a href="/CoachPro_V3/public/index.php?url=coach/addSeance" class="btn btn-primary">Ajouter une séance</a>
</div>

<?php if ($success = Session::getFlash('success')): ?>
    <div class="alert alert-success"><?= Security::escape($success) ?></div>
<?php endif; ?>

<?php if ($error = Session::getFlash('error')): ?>
    <div class="alert alert-error"><?= Security::escape($error) ?></div>
<?php endif; ?>

<?php if (empty($seances)): ?>
    <p>Vous n'avez pas encore créé de séance.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seances as $seance): ?>
                <tr>
                    <td><?= Security::escape($seance['titre']) ?></td>
                    <td><?= Security::escape($seance['date_seance']) ?></td>
                    <td><?= Security::escape($seance['heure_debut']) ?> - <?= Security::escape($seance['heure_fin']) ?></td>
                    <td><?= Security::escape($seance['places_disponibles']) ?></td>
                    <td>
                        <a href="/CoachPro_V3/public/index.php?url=coach/editSeance&id=<?= $seance['id'] ?>" class="btn btn-sm">Modifier</a>
                        <a href="/CoachPro_V3/public/index.php?url=coach/deleteSeance&id=<?= $seance['id'] ?>&token=<?= Security::generateToken() ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
