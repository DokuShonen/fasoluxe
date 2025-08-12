<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/client_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Mon Profil</h2>

        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="success-message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <p class="error-message"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
        <?php endif; ?>

        <div class="form-container">
            <h3>Informations Personnelles</h3>
            <form action="<?php echo BASE_URL; ?>client/profile.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($client['nom']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($client['prenom']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($client['telephone']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="classification">Classification</label>
                        <input type="text" id="classification" value="<?php echo htmlspecialchars($client['classification']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="carte_fidelite">Carte de Fidelite</label>
                        <input type="checkbox" id="carte_fidelite" <?php echo ($client['carte_fidelite'] == 1) ? 'checked' : ''; ?> disabled>
                    </div>
                    <div class="form-group">
                        <label for="reduction">Reduction</label>
                        <input type="text" id="reduction" value="<?php echo htmlspecialchars($client['reduction']); ?>%" disabled>
                    </div>
                </div>
                <button type="submit" class="btn">Mettre a jour le profil</button>
            </form>
        </div>

        <div class="form-container" style="margin-top: 30px;">
            <h3>Changer le mot de passe</h3>
            <form action="<?php echo BASE_URL; ?>client/profile.php" method="POST">
                <input type="hidden" name="action" value="change_password">
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_new_password">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                </div>
                <button type="submit" class="btn">Changer le mot de passe</button>
            </form>
        </div>
    </main>
</div>