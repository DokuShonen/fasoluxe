<?php
require_once __DIR__ . '/../../src/includes/auth_client.php';
require_once __DIR__ . '/../../src/models/Reservation.php';

$reservation_id = $_GET['id'] ?? null;

if (!$reservation_id || !is_numeric($reservation_id)) {
    header('Location: mes_reservations.php');
    exit();
}

$reservation_details = Reservation::findByIdWithDetails($reservation_id);

// Verifier que la reservation appartient bien au client connecte
if (!$reservation_details || $reservation_details['client_email'] !== $current_client['email']) {
    header('Location: mes_reservations.php');
    exit();
}

// Calcul du nombre de nuits et du prix total
$datetime1 = new DateTime($reservation_details['date_arrivee']);
$datetime2 = new DateTime($reservation_details['date_depart']);
$interval = $datetime1->diff($datetime2);
$nb_nuits = $interval->days;

$prix_total_brut = $nb_nuits * $reservation_details['tarif_nuit'];

// Appliquer la reduction si elle existe
$reduction = $reservation_details['client_reduction'] ?? 0;
$montant_ttc = $prix_total_brut * (1 - $reduction);

// Calcul de la TVA (18%)
$tva_rate = 0.18;
$montant_tva = $montant_ttc * $tva_rate;

$reservation_details['nb_nuits'] = $nb_nuits;
$reservation_details['montant_ttc'] = $montant_ttc;
$reservation_details['tva'] = $montant_tva;

// Inclure l'entete
include_once __DIR__ . '/../../src/includes/header.php';

// Inclure la vue
include_once __DIR__ . '/../../templates/client_reservation_details.php';

// Inclure le pied de page
include_once __DIR__ . '/../../src/includes/footer.php';
?>