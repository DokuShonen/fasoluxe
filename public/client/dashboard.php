<?php
require_once __DIR__ . '/../../src/includes/auth_client.php';
require_once __DIR__ . '/../../src/models/Reservation.php';

// Recuperer les reservations en cours pour le client
$reservations_en_cours = Reservation::getReservationsEnCoursByClientId($current_client['id']);

$montant_du = 0;
foreach ($reservations_en_cours as $res) {
    // Recalculer le montant du pour chaque reservation en cours
    $datetime1 = new DateTime($res['date_arrivee']);
    $datetime2 = new DateTime(date('Y-m-d')); // Date actuelle
    $interval = $datetime1->diff($datetime2);
    $nuits_passees = $interval->days;

    $montant_reservation = $nuits_passees * $res['tarif_nuit'];

    // Appliquer la reduction si le client en a une
    if ($res['client_reduction'] > 0) {
        $montant_reservation = $montant_reservation * (1 - ($res['client_reduction'] / 100));
    }
    $montant_du += $montant_reservation;
}

// Inclure l'entete
include_once __DIR__ . '/../../src/includes/header.php';
?>

<div class="dashboard-container">
    <?php include __DIR__ . '/../../src/includes/client_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Tableau de Bord</h2>
        <p>Bonjour, <strong><?php echo htmlspecialchars($current_client['nom']); ?></strong> !</p>
        <p>Bienvenue dans votre espace personnel. D'ici, vous pouvez gerer vos reservations et votre profil.</p>

        <div class="info-card">
            <h3>Montant du a ce jour</h3>
            <p class="amount-due"><?php echo number_format($montant_du, 0, ',', ' '); ?> FCFA</p>
            <p>Ce montant est une estimation basee sur vos reservations en cours et les nuits deja passees.</p>
        </div>

    </main>
</div>

<?php
// Inclure le pied de page
include_once __DIR__ . '/../../src/includes/footer.php';
?>