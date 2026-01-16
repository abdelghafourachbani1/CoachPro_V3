<?php $pageTitle = 'Mon Profil Coach'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<h1>Mon Profil Coach</h1>

<?php if ($coach): ?>
    <div class="card">
        <h2><?= htmlspecialchars($coach['prenom']) ?> <?= htmlspecialchars($coach['nom']) ?></h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($coach['email']) ?></p>
        <p><strong>Spécialités:</strong> <?= htmlspecialchars($coach['specialites']) ?></p>
        <p><strong>Expérience:</strong> <?= htmlspecialchars($coach['experience']) ?> ans</p>
        <p><strong>Tarif horaire:</strong> <?= htmlspecialchars($coach['tarif_horaire']) ?> €</p>
        <p><strong>Description:</strong> <?= htmlspecialchars($coach['description']) ?></p>
    </div>
<?php else: ?>
    <p>Profil non trouvé.</p>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>