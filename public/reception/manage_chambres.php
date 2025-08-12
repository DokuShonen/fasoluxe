<?php
require_once __DIR__ . '/../../src/includes/auth_reception.php';
require_once __DIR__ . '/../../src/models/Chambre.php';
require_once __DIR__ . '/../../src/models/Hotel.php';

$hotel_id = $current_user['hotel_id'] ?? null;

// Si l'utilisateur est un Admin sans hotel_id specifique, il ne peut pas voir cette page
if ($current_user['role'] === 'Admin' && is_null($hotel_id)) {
    $_SESSION['error_message'] = "En tant qu'administrateur general, vous devez selectionner un hotel pour gerer les chambres.";
    header('Location: /fasoluxe_project/admin/dashboard.php'); // Rediriger vers le dashboard admin
    exit();
}

$chambres = [];
$hotel_name = "";

if (!is_null($hotel_id)) {
    $chambres = Chambre::getAllByHotelId($hotel_id);
    $hotel_info = Hotel::findById($hotel_id);
    if ($hotel_info) {
        $hotel_name = $hotel_info['nom'];
    }
}

// Inclure l'entete
include_once __DIR__ . '/../../src/includes/header.php';

// Inclure la vue
include_once __DIR__ . '/../../templates/reception_manage_chambres.php';

// Inclure le pied de page
include_once __DIR__ . '/../../src/includes/footer.php';
?>