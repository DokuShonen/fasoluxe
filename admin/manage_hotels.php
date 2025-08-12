<?php
require_once __DIR__ . '/../src/includes/auth_admin.php';
require_once __DIR__ . '/../src/models/Hotel.php';

$action = $_REQUEST['action'] ?? null;
$id = $_REQUEST['id'] ?? null;

// Traitement des actions POST (Create, Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    if ($action === 'create') {
        Hotel::create($data);
    }
    if ($action === 'update' && $id) {
        Hotel::update($id, $data);
    }
    header('Location: manage_hotels.php');
    exit();
}

// Traitement des actions GET (Delete)
if ($action === 'delete' && $id) {
    Hotel::delete($id);
    header('Location: manage_hotels.php');
    exit();
}

// Preparation pour l'affichage
$hotels = Hotel::getAll();
$is_editing = false;
$hotel_to_edit = [];

if ($action === 'edit' && $id) {
    $is_editing = true;
    $hotel_to_edit = Hotel::findById($id);
}

// Inclure les fichiers de la vue
include_once __DIR__ . '/../src/includes/header.php';
include_once __DIR__ . '/../templates/admin_manage_hotels.php';
include_once __DIR__ . '/../src/includes/footer.php';
?>