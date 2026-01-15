<?php $pageTitle = 'Inscription'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Inscription</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/sport-mvc/public/index.php?url=auth/doRegister" method="POST">
            <div class="form-group">
                <label for="role">Je suis :</label>
                <select id="role" name="role" onchange="toggleCoachFields()">
                    <option value="sportif">Sportif</option>
                    <option value="coach">Coach</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6">
            </div>

            <div id="sportif-fields">
                <div class="form-group">
                    <label for="niveau">Niveau</label>
                    <select id="niveau" name="niveau">
                        <option value="Débutant">Débutant</option>
                        <option value="Intermédiaire">Intermédiaire</option>
                        <option value="Avancé">Avancé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="objectifs">Objectifs</label>
                    <textarea id="objectifs" name="objectifs" rows="3"></textarea>
                </div>
            </div>

            <div id="coach-fields" style="display: none;">
                <div class="form-group">
                    <label for="specialites">Spécialités</label>
                    <input type="text" id="specialites" name="specialites" placeholder="Ex: Yoga, Fitness">
                </div>

                <div class="form-group">
                    <label for="experience">Années d'expérience</label>
                    <input type="number" id="experience" name="experience" min="0" value="0">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="tarif_horaire">Tarif horaire (€)</label>
                    <input type="number" id="tarif_horaire" name="tarif_horaire" step="0.01" min="0" value="0">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>

        <p class="text-center mt-3">
            Déjà un compte ? <a href="/sport-mvc/public/index.php?url=auth/login">Se connecter</a>
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