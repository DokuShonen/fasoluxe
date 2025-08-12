<?php
require_once __DIR__ . '/../../src/includes/auth_reception.php';
require_once __DIR__ . '/../../src/models/Reservation.php';

$hotel_id = $current_user['hotel_id'] ?? null;

// Si l'utilisateur est un Admin sans hotel_id specifique, il ne peut pas voir cette page
if ($current_user['role'] === 'Admin' && is_null($hotel_id)) {
    $_SESSION['error_message'] = "En tant qu'administrateur general, vous devez selectionner un hotel pour voir toutes les reservations.";
        header('Location: /fasoluxe_project/public/reception/all_reservations.php'); // Rediriger vers le dashboard admin
    exit();
}

$all_reservations = [];
if (!is_null($hotel_id)) {
    $all_reservations = Reservation::getAllReservationsByHotelId($hotel_id);
}

// Inclure l'entete
include_once __DIR__ . '/../../src/includes/header.php';

// Inclure la vue
include_once __DIR__ . '/../../templates/reception_all_reservations.php';

// Inclure le pied de page
include_once __DIR__ . '/../../src/includes/footer.php';
?>