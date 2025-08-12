<?php
require_once __DIR__ . '/../src/includes/auth_admin.php';
require_once __DIR__ . '/../src/models/Chambre.php';
require_once __DIR__ . '/../src/models/Hotel.php';
require_once __DIR__ . '/../src/models/TypeChambre.php';

$action = $_REQUEST['action'] ?? null;
$id = $_REQUEST['id'] ?? null;

// Traitement des actions POST (Create, Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    if ($action === 'create') {
        Chambre::create($data);
    }
    if ($action === 'update' && $id) {
        Chambre::update($id, $data);
    }
    header('Location: manage_chambres.php');
    exit();
}

// Traitement des actions GET (Delete)
if ($action === 'delete' && $id) {
    Chambre::delete($id);
    header('Location: manage_chambres.php');
    exit();
}

// Preparation pour l'affichage
$chambres = Chambre::getAll();
$hotels = Hotel::getAll(); // Pour le select des hotels
$types_chambre = TypeChambre::getAll(); // Pour le select des types de chambre

$is_editing = false;
$chambre_to_edit = [];

if ($action === 'edit' && $id) {
    $is_editing = true;
    $chambre_to_edit = Chambre::findById($id);
}

// Inclure les fichiers de la vue
include_once __DIR__ . '/../src/includes/header.php';
include_once __DIR__ . '/../templates/admin_manage_chambres.php';
include_once __DIR__ . '/../src/includes/footer.php';
?>