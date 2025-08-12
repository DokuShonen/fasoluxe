<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../src/includes/auth_reception.php';
require_once __DIR__ . '/../../src/models/Reservation.php';

// L'hotel_id est stocke dans la session de l'utilisateur
$hotel_id = $current_user['hotel_id'] ?? null;

// Si l'utilisateur est un Admin sans hotel_id specifique, il ne peut pas voir ce dashboard
if ($current_user['role'] === 'Admin' && is_null($hotel_id)) {
    $_SESSION['error_message'] = "En tant qu'administrateur general, vous devez selectionner un hotel pour voir l'activite de reception.";
    header('Location: /Nouveaux/fasoluxe_project/admin/dashboard.php'); // Rediriger vers le dashboard admin
    exit();
}

$today = date('Y-m-d');

// --- Traitement des actions Check-in / Check-out ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $reservation_id = $_GET['id'];
    $action_type = $_GET['action'];
    
    if ($action_type === 'checkin') {
        $success = Reservation::updateStatus($reservation_id, 'En cours');
    }
    if ($action_type === 'checkout') {
        $success = Reservation::updateStatus($reservation_id, 'Terminee');
    }
    // Rediriger pour nettoyer l'URL
    header('Location: /fasoluxe_project/public/reception/dashboard.php');
    exit();
}

// Recuperer toute l'activite du jour
$activite_jour = Reservation::getDailyActivity($hotel_id, $today);

// Trier les resultats en 3 listes
$arrivees = [];
$departs = [];
$occupants = [];

foreach ($activite_jour as $res) {
    if ($res['date_arrivee'] === $today && $res['statut'] === 'Confirmee') {
        $arrivees[] = $res;
    }
    if ($res['date_depart'] === $today && $res['statut'] === 'En cours') {
        $departs[] = $res;
    }
    if ($res['statut'] === 'En cours') {
        $occupants[] = $res;
    }
}

// Inclure l'entete
include_once __DIR__ . '/../../src/includes/header.php';

// Inclure la vue
include_once __DIR__ . '/../../templates/reception_dashboard.php';

// Inclure le pied de page
include_once __DIR__ . '/../../src/includes/footer.php';
?>