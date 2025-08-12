<?php
require_once __DIR__ . '/../../src/includes/auth_reception.php';
require_once __DIR__ . '/../../src/models/Reservation.php';
require_once __DIR__ . '/../../src/models/Hotel.php';

$reservation_id = $_GET['id'] ?? null;

if (!$reservation_id || !is_numeric($reservation_id)) {
    $_SESSION['error_message'] = "Reservation invalide.";
    header('Location: /fasoluxe_project/public/reception/all_reservations.php');
    exit();
}

$reservation_details = Reservation::getReservationDetailsForInvoice($reservation_id);

// Verifier que la reservation appartient bien a l'hotel de l'agent
$hotel_id_agent = $current_user['hotel_id'] ?? null;

if (!$reservation_details || $reservation_details['hotel_nom'] !== Hotel::findById($hotel_id_agent)['nom']) {
    $_SESSION['error_message'] = "Vous n'etes pas autorise a annuler cette reservation.";
    header('Location: /fasoluxe_project/public/reception/all_reservations.php');
    exit();
}

// Annuler la reservation
if (Reservation::updateStatus($reservation_id, 'Annulee')) {
    $_SESSION['success_message'] = "La reservation #" . htmlspecialchars($reservation_details['numero_confirmation']) . " a ete annulee avec succes.";
} else {
    $_SESSION['error_message'] = "Une erreur est survenue lors de l'annulation de la reservation.";
}

header('Location: /fasoluxe_project/public/reception/all_reservations.php');
exit();
?>