<?php
require_once __DIR__ . '/../src/models/Hotel.php';

// Recuperer tous les hotels
$hotels = Hotel::getAll();

// Inclure l'entete
include_once __DIR__ . '/../src/includes/header.php';

// Inclure la vue de la liste des hotels
include_once __DIR__ . '/../templates/hotels_list.php';

// Inclure le pied de page
include_once __DIR__ . '/../src/includes/footer.php';
?>