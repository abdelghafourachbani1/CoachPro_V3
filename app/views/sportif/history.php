<?php $pageTitle = 'Mes Réservations'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Mes Réservations</h1>

<?php if ($success = Session::getFlash('success')): ?>
    <div class="alert alert-success"><?= Security::escape($success) ?></div>
<?php endif; ?>

<?php if ($error = Session::getFlash('error')): ?>
    <div class="alert alert-error"><?= Security::escape($error) ?></div>
<?php endif; ?>

<?php if (empty($reservations)): ?>
    <p>Vous n'avez pas encore de réservation.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Séance</th>
                <th>Coach</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Date de réservation</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= Security::escape($reservation['titre']) ?></td>
                    <td><?= Security::escape($reservation['coach_prenom']) ?> <?= Security::escape($reservation['coach_nom']) ?></td>
                    <td><?= Security::escape($reservation['date_seance']) ?></td>
                    <td><?= Security::escape($reservation['heure_debut']) ?> - <?= Security::escape($reservation['heure_fin']) ?></td>
                    <td><?= Security::escape($reservation['date_reservation']) ?></td>
                    <td><span class="badge badge-success"><?= Security::escape($reservation['statut']) ?></span></td>
                    <td>
                        <?php 
                        // Vérifier si la séance est dans le futur
                        $dateSeance = strtotime($reservation['date_seance']);
                        $aujourdhui = strtotime(date('Y-m-d'));
                        if ($dateSeance >= $aujourdhui): 
                        ?>
                            <a href="/CoachPro_V3/public/index.php?url=sportif/cancelReservation&id=<?= $reservation['id'] ?>&token=<?= Security::generateToken() ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Annuler cette réservation ?')">Annuler</a>
                        <?php else: ?>
                            <span class="text-muted">Terminée</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>