<div class="container">
    <div class="main-content">
        <h2 class="page-title">Nos Hotels</h2>
        <?php if (empty($hotels)): ?>
            <p>Aucun hotel disponible pour le moment.</p>
        <?php else: ?>
            <div class="hotels-grid">
                <?php foreach ($hotels as $hotel): ?>
                    <div class="hotel-card">
                        <img src="images/default-hotel.jpg" alt="Facade de l'hotel <?php echo htmlspecialchars($hotel['nom']); ?>">
                        <div class="hotel-card-content">
                            <h3><?php echo htmlspecialchars($hotel['nom']); ?></h3>
                            <p><strong>Ville :</strong> <?php echo htmlspecialchars($hotel['ville']); ?></p>
                            <p><?php echo substr(htmlspecialchars($hotel['description']), 0, 100) . '...'; ?></p>
                            <a href="<?php echo BASE_URL; ?>public/hotel_details.php?id=<?php echo $hotel['id']; ?>" class="btn">Voir les details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>