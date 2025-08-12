<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/client_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Details de la Reservation</h2>

        <?php if ($reservation_details): ?>
            <div class="reservation-details-card">
                <h3>Reservation #<?php echo htmlspecialchars($reservation_details['numero_confirmation']); ?></h3>
                <p><strong>Client :</strong> <?php echo htmlspecialchars($reservation_details['client_prenom'] . ' ' . $reservation_details['client_nom']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($reservation_details['client_email']); ?></p>
                <p><strong>Telephone :</strong> <?php echo htmlspecialchars($reservation_details['client_telephone']); ?></p>
                <hr>
                <p><strong>Hotel :</strong> <?php echo htmlspecialchars($reservation_details['hotel_nom']); ?> (<?php echo htmlspecialchars($reservation_details['hotel_ville']); ?>)</p>
                <p><strong>Adresse :</strong> <?php echo htmlspecialchars($reservation_details['hotel_adresse']); ?></p>
                <hr>
                <p><strong>Chambre :</strong> <?php echo htmlspecialchars($reservation_details['type_chambre_nom']); ?> (Numero: <?php echo htmlspecialchars($reservation_details['numero_chambre']); ?>)</p>
                <p><strong>Equipements :</strong> <?php echo htmlspecialchars($reservation_details['equipements'] ?? 'Non specifie'); ?></p>
                <hr>
                <p><strong>Date d'arrivee :</strong> <?php echo htmlspecialchars($reservation_details['date_arrivee']); ?></p>
                <p><strong>Date de depart :</strong> <?php echo htmlspecialchars($reservation_details['date_depart']); ?></p>
                <p><strong>Nombre de nuits :</strong> <?php echo htmlspecialchars($reservation_details['nb_nuits']); ?></p>
                <hr>
                <p><strong>Tarif par nuit :</strong> <?php echo number_format($reservation_details['tarif_nuit'], 0, ',', ' '); ?> FCFA</p>
                <p><strong>Montant HT :</strong> <?php echo number_format($reservation_details['montant_ht'], 0, ',', ' '); ?> FCFA</p>
                <p><strong>TVA (18%) :</strong> <?php echo number_format($reservation_details['tva'], 0, ',', ' '); ?> FCFA</p>
                <p><strong>Montant Total TTC :</strong> <?php echo number_format($reservation_details['montant_ttc'], 0, ',', ' '); ?> FCFA</p>
                <?php if ($reservation_details['client_reduction'] > 0): ?>
                    <p><strong>Reduction appliquee :</strong> <?php echo htmlspecialchars($reservation_details['client_reduction']); ?>%</p>
                <?php endif; ?>
            </div>
            <a href="<?php echo BASE_URL; ?>client/mes_reservations.php" class="btn">Retour a mes reservations</a>
        <?php else: ?>
            <p>Details de la reservation non trouves.</p>
            <a href="<?php echo BASE_URL; ?>client/mes_reservations.php" class="btn">Retour a mes reservations</a>
        <?php endif; ?>
    </main>
</div>