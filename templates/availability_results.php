<div class="container">
    <div class="main-content">
        <h2 class="page-title">Chambres Disponibles</h2>
        <p>Resultats pour la periode du <strong><?php echo htmlspecialchars($date_arrivee); ?></strong> au <strong><?php echo htmlspecialchars($date_depart); ?></strong>.</p>

        <?php if (empty($chambres_disponibles)): ?>
            <p>Desole, aucune chambre n'est disponible pour cette periode. Veuillez essayer d'autres dates.</p>
        <?php else: ?>
            <div class="chambres-grid">
                <?php foreach ($chambres_disponibles as $chambre): ?>
                    <div class="chambre-card">
                        <h3><?php echo htmlspecialchars($chambre['hotel_nom']); ?></h3>
                        <h4><?php echo htmlspecialchars($chambre['type_nom']); ?></h4>
                        <p><strong>Ville :</strong> <?php echo htmlspecialchars($chambre['hotel_ville']); ?></p>
                        <p><strong>Equipements :</strong> <?php echo htmlspecialchars($chambre['equipements']); ?></p>
                        <p class="tarif"><strong><?php echo number_format($chambre['tarif_nuit'], 0, ',', ' '); ?> FCFA</strong> / nuit</p>
                        <a href="<?php echo BASE_URL; ?>public/reservation.php?chambre_id=<?php echo $chambre['id']; ?>&arrivee=<?php echo $date_arrivee; ?>&depart=<?php echo $date_depart; ?>" class="btn">Reserver maintenant</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>