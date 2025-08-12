<div class="container">
    <div class="main-content">
        <div class="confirmation-box">
            <div class="confirmation-icon">
                &#10004; <!-- Checkmark symbol -->
            </div>
            <h2>Merci, <?php echo htmlspecialchars($reservation_details['client_prenom']); ?> !</h2>
            <p class="confirmation-lead">Votre reservation a ete confirmee avec succes.</p>
            <p>Un email de confirmation a ete envoye a votre adresse. Conservez precieusement votre numero de reservation.</p>

            <div class="confirmation-details">
                <h3>Recapitulatif de votre reservation</h3>
                <p><strong>Numero de reservation :</strong> <span class="confirmation-number"><?php echo htmlspecialchars($reservation_details['numero_confirmation']); ?></span></p>
                <p><strong>Hotel :</strong> <?php echo htmlspecialchars($reservation_details['hotel_nom']); ?> (<?php echo htmlspecialchars($reservation_details['hotel_ville']); ?>)</p>
                <p><strong>Adresse :</strong> <?php echo htmlspecialchars($reservation_details['hotel_adresse']); ?></p>
                <p><strong>Chambre :</strong> <?php echo htmlspecialchars($reservation_details['type_chambre_nom']); ?></p>
                <p><strong>Date d'arrivee :</strong> <?php echo htmlspecialchars($reservation_details['date_arrivee']); ?></p>
                <p><strong>Date de depart :</strong> <?php echo htmlspecialchars($reservation_details['date_depart']); ?></p>
            </div>

            <a href="<?php echo BASE_URL; ?>public/index.php" class="btn">Retour a l'accueil</a>
        </div>
    </div>
</div>