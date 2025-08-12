<?php
require_once __DIR__ . '/../src/includes/auth_admin.php';
require_once __DIR__ . '/../src/models/Reservation.php';
require_once __DIR__ . '/../src/models/Hotel.php';
require_once __DIR__ . '/../src/models/Chambre.php';

// Recuperer les dates et l'hotel selectionnes
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-t');
$selected_hotel_id = $_GET['hotel_id'] ?? null;

// Recuperer toutes les reservations pour la periode et l'hotel (si selectionne)
$occupancy_data = Reservation::getOccupancyData($start_date, $end_date, $selected_hotel_id);

// Recuperer tous les hotels pour le filtre
$hotels = Hotel::getAll();

// Calcul du taux d'occupation
$occupancy_stats = [];
$all_chambres = Chambre::getAll(); // Toutes les chambres pour calculer le total par hotel

// Initialiser les stats par hotel
foreach ($hotels as $hotel) {
    $occupancy_stats[$hotel['nom']] = [
        'total_chambres' => 0,
        'nuits_reservees' => 0,
        'taux_occupation' => 0
    ];
}

// Compter le nombre total de chambres par hotel
foreach ($all_chambres as $chambre) {
    foreach ($hotels as $hotel) {
        if ($chambre['hotel_nom'] === $hotel['nom']) {
            $occupancy_stats[$hotel['nom']]['total_chambres']++;
            break;
        }
    }
}

// Calculer les nuits reservees
foreach ($occupancy_data as $reservation) {
    $date_arrivee = new DateTime($reservation['date_arrivee']);
    $date_depart = new DateTime($reservation['date_depart']);
    $interval = $date_arrivee->diff($date_depart);
    $nuits = $interval->days;

    if (isset($occupancy_stats[$reservation['hotel_nom']])) {
        $occupancy_stats[$reservation['hotel_nom']]['nuits_reservees'] += $nuits;
    }
}

// Calculer le taux d'occupation
foreach ($occupancy_stats as $hotel_name => &$data) {
    if ($data['total_chambres'] > 0) {
        // Nombre de jours dans la periode
        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime($end_date);
        $interval_days = $datetime1->diff($datetime2)->days + 1; // +1 pour inclure le jour de fin

        $capacite_nuits = $data['total_chambres'] * $interval_days;
        if ($capacite_nuits > 0) {
            $data['taux_occupation'] = ($data['nuits_reservees'] / $capacite_nuits) * 100;
        }
    }
}

// Inclure les fichiers de la vue
include_once __DIR__ . '/../src/includes/header.php';
include_once __DIR__ . '/../templates/admin_statistics.php';
include_once __DIR__ . '/../src/includes/footer.php';
?>