<?php
require_once __DIR__ . '/../src/models/Reservation.php';
session_start();

// Verifier si un numero de confirmation est en session
if (!isset($_SESSION['confirmation_id'])) {
    header('Location: /fasoluxe_project/public/index.php');
    exit();
}

$numero_confirmation = $_SESSION['confirmation_id'];

// Recuperer les details de la reservation
$reservation_details = Reservation::findByConfirmationNumber($numero_confirmation);

// Vider la variable de session pour ne pas la reutiliser
unset($_SESSION['confirmation_id']);

if (!$reservation_details) {
    // Si la reservation n'est pas trouvee, rediriger avec une erreur (a creer)
    header('Location: /fasoluxe_project/public/index.php');
    exit();
}

// Inclure l'entete
include_once __DIR__ . '/../src/includes/header.php';

// Inclure la vue de confirmation
include_once __DIR__ . '/../templates/confirmation_page.php';

// Inclure le pied de page
include_once __DIR__ . '/../src/includes/footer.php';
?>