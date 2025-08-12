<?php
require_once __DIR__ . '/../src/models/Chambre.php';

// Recuperation et validation des donnees du formulaire
$date_arrivee = $_POST['date_arrivee'] ?? null;
$date_depart = $_POST['date_depart'] ?? null;
$ville = $_POST['ville'] ?? '';
$personnes = $_POST['personnes'] ?? 1;

// TODO: Ajouter une validation plus robuste

$chambres_disponibles = [];
if ($date_arrivee && $date_depart) {
    $chambres_disponibles = Chambre::findAvailable($date_arrivee, $date_depart, $ville, $personnes);
}

// Inclure l'entete
include_once __DIR__ . '/../src/includes/header.php';

// Inclure la vue des resultats
include_once __DIR__ . '/../templates/availability_results.php';

// Inclure le pied de page
include_once __DIR__ . '/../src/includes/footer.php';
?>