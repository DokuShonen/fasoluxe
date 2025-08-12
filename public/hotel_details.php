<?php
require_once __DIR__ . '/../src/models/Hotel.php';

// Verifier si un ID est passe en parametre
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /fasoluxe_project/public/hotels.php');
    exit();
}

$hotel_id = $_GET['id'];

// Recuperer les informations de l'hotel, ses chambres et ses services
$hotel = Hotel::findById($hotel_id);
$chambres = Hotel::getChambres($hotel_id);
$services = Hotel::getServices($hotel_id);

// Si l'hotel n'existe pas, rediriger
if (!$hotel) {
    header('Location: /fasoluxe_project/public/hotels.php');
    exit();
}

// Inclure l'entete
include_once __DIR__ . '/../src/includes/header.php';

// Inclure la vue des details de l'hotel
include_once __DIR__ . '/../templates/hotel_details.php';

// Inclure le pied de page
include_once __DIR__ . '/../src/includes/footer.php';
?>