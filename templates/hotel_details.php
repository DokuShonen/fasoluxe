<div class="container">
    <div class="main-content">
        <?php if ($hotel): ?>
            <h2 class="page-title"><?php echo htmlspecialchars($hotel['nom']); ?></h2>
            
            <div class="hotel-details-grid">
                <div class="hotel-image">
                    <img src="images/default-hotel.jpg" alt="Facade de l'hotel <?php echo htmlspecialchars($hotel['nom']); ?>">
                </div>
                <div class="hotel-info">
                    <h3><?php echo htmlspecialchars($hotel['ville']); ?></h3>
                    <p><strong>Adresse :</strong> <?php echo htmlspecialchars($hotel['adresse']); ?></p>
                    <p><strong>Categorie :</strong> <?php echo str_repeat('&#9733;', $hotel['categorie']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($hotel['description'])); ?></p>
                    <p>
                        <a href="mailto:<?php echo htmlspecialchars($hotel['email']); ?>" class="btn">Contacter par Email</a>
                        <a href="<?php echo htmlspecialchars($hotel['site_web']); ?>" target="_blank" class="btn">Site Web</a>
                    </p>
                </div>
            </div>

            <h3 class="section-title">Selectionnez vos dates</h3>
            <div class="booking-form-container" style="margin-top: 0;">
                <form id="dateSelectionForm" class="booking-form">
                    <div class="form-group">
                        <label for="arrivee_date">Arrivee</label>
                        <input type="date" id="arrivee_date" name="arrivee_date" required>
                    </div>
                    <div class="form-group">
                        <label for="depart_date">Depart</label>
                        <input type="date" id="depart_date" name="depart_date" required>
                    </div>
                    <button type="button" class="btn" onclick="updateReservationLinks()">Mettre a jour les disponibilites</button>
                </form>
            </div>

            <h3 class="section-title">Nos Chambres</h3>
            <div class="chambres-grid">
                <?php foreach ($chambres as $chambre): ?>
                    <div class="chambre-card">
                        <h4><?php echo htmlspecialchars($chambre['type_nom']); ?></h4>
                        <p><strong>Equipements :</strong> <?php echo htmlspecialchars($chambre['equipements']); ?></p>
                        <p class="tarif">A partir de <strong><?php echo number_format($chambre['tarif_nuit'], 0, ',', ' '); ?> FCFA</strong> / nuit</p>
                        <a href="#" class="btn reservation-btn" data-chambre-id="<?php echo $chambre['id']; ?>">Reserver</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <h3 class="section-title">Services de l'hotel</h3>
            <ul class="services-list">
                <?php foreach ($services as $service): ?>
                    <li><?php echo htmlspecialchars($service['nom']); ?> <?php echo ($service['tarif'] > 0) ? '(' . number_format($service['tarif'], 0, ',', ' ') . ' FCFA)' : '(Inclus)'; ?></li>
                <?php endforeach; ?>
            </ul>

        <?php else: ?>
            <p>Hotel non trouve.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function updateReservationLinks() {
        const arriveeDate = document.getElementById('arrivee_date').value;
        const departDate = document.getElementById('depart_date').value;

        if (!arriveeDate || !departDate) {
            alert('Veuillez selectionner les dates d\'arrivee et de depart.');
            return;
        }

        const reservationButtons = document.querySelectorAll('.reservation-btn');
        reservationButtons.forEach(button => {
            const chambreId = button.dataset.chambreId;
            button.href = `<?php echo BASE_URL; ?>public/reservation.php?chambre_id=${chambreId}&arrivee=${arriveeDate}&depart=${departDate}`;
        });
    }

    // Initialiser les dates par defaut (aujourd'hui et demain)
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);

        const formatDate = (date) => {
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        };

        document.getElementById('arrivee_date').value = formatDate(today);
        document.getElementById('depart_date').value = formatDate(tomorrow);

        // Mettre a jour les liens des boutons au chargement de la page
        updateReservationLinks();
    });
</script>
