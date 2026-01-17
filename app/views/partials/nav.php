<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$role = $_SESSION['user_role'] ?? null;
$nom = $_SESSION['user_nom'] ?? '';
$prenom = $_SESSION['user_prenom'] ?? '';
?>

<nav class="navbar">
    <div class="nav-container">
        <a href="/CoachPro_V3/public/" class="logo">Sport MVC</a>

        <ul class="nav-menu">
            <?php if ($isLoggedIn): ?>
                <li><span class="user-name">Bonjour, <?= htmlspecialchars($prenom) ?> <?= htmlspecialchars($nom) ?></span></li>

                <?php if ($role === 'coach'): ?>
                    <li><a href="/CoachPro_V3/public/index.php?url=coach/profile">Mon Profil</a></li>
                    <li><a href="/CoachPro_V3/public/index.php?url=coach/seances">Mes Séances</a></li>
                    <li><a href="/CoachPro_V3/public/index.php?url=coach/reservations">Réservations</a></li>
                <?php else: ?>
                    <li><a href="/CoachPro_V3/public/index.php?url=sportif/coaches">Coaches</a></li>
                    <li><a href="/CoachPro_V3/public/index.php?url=sportif/seances">Séances</a></li>
                    <li><a href="/CoachPro_V3/public/index.php?url=sportif/history">Mes Réservations</a></li>
                <?php endif; ?>

                <li><a href="/CoachPro_V3/public/index.php?url=auth/logout" class="btn-logout">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/CoachPro_V3/public/index.php?url=auth/login">Connexion</a></li>
                <li><a href="/CoachPro_V3/public/index.php?url=auth/register">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>