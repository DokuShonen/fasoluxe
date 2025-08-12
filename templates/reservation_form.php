<div class="container">
    <div class="main-content">
        <h2 class="page-title">Finaliser votre Reservation</h2>

        <?php if (isset($_SESSION['error_message'])): ?>
            <p class="error-message"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
        <?php endif; ?>

        <div class="reservation-grid">
            <!-- Colonne 1: Resume de la reservation -->
            <div class="reservation-summary">
                <h3>Votre Sejour</h3>
                <div class="summary-card">
                    <img src="images/default-hotel.jpg" alt="Image de la chambre">
                    <h4><?php echo htmlspecialchars($chambre['hotel_nom']); ?></h4>
                    <p><strong>Chambre :</strong> <?php echo htmlspecialchars($chambre['type_nom']); ?></p>
                    <p><strong>Arrivee :</strong> <?php echo htmlspecialchars($date_arrivee); ?></p>
                    <p><strong>Depart :</strong> <?php echo htmlspecialchars($date_depart); ?></p>
                    <p><strong>Nuits :</strong> <?php echo $nb_nuits; ?></p>
                    <hr>
                    <p class="total-price">Total estime : <strong><?php echo number_format($prix_total, 0, ',', ' '); ?> FCFA</strong></p>
                </div>
            </div>

            <!-- Colonne 2: Formulaire client -->
            <div class="client-form">
                <h3>Vos Coordonnees</h3>
                <form action="<?php echo BASE_URL; ?>public/reservation.php" method="POST">
                    <!-- Champs caches pour passer les infos de la reservation -->
                    <input type="hidden" name="chambre_id" value="<?php echo $chambre['id']; ?>">
                    <input type="hidden" name="date_arrivee" value="<?php echo $date_arrivee; ?>">
                    <input type="hidden" name="date_depart" value="<?php echo $date_depart; ?>">

                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                    <button type="submit" class="btn">Confirmer la reservation</button>
                </form>
            </div>
        </div>
    </div>
</div>