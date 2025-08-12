<?php
require_once __DIR__ . '/../../src/includes/auth_client.php';
require_once __DIR__ . '/../../src/models/Reservation.php';

// Recuperer l'ID du client connecte
$client_id = $current_client['id'];

// Recuperer ses reservations
$reservations = Reservation::findByClientId($client_id);

// Inclure l'entete
include_once __DIR__ . '/../../src/includes/header.php';

// Inclure la vue
include_once __DIR__ . '/../../templates/client_reservations.php';

// Inclure le pied de page
include_once __DIR__ . '/../../src/includes/footer.php';
?>