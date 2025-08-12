<?php
require_once __DIR__ . '/../src/includes/auth_admin.php';
require_once __DIR__ . '/../src/models/Service.php';
require_once __DIR__ . '/../src/models/Hotel.php';

$action = $_REQUEST['action'] ?? null;
$id = $_REQUEST['id'] ?? null;

// Traitement des actions POST (Create, Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    if ($action === 'create') {
        Service::create($data);
    }
    if ($action === 'update' && $id) {
        Service::update($id, $data);
    }
    header('Location: manage_services.php');
    exit();
}

// Traitement des actions GET (Delete)
if ($action === 'delete' && $id) {
    Service::delete($id);
    header('Location: manage_services.php');
    exit();
}

// Preparation pour l'affichage
$services = Service::getAll();
$hotels = Hotel::getAll(); // Pour le select des hotels

$is_editing = false;
$service_to_edit = [];

if ($action === 'edit' && $id) {
    $is_editing = true;
    $service_to_edit = Service::findById($id);
}

// Inclure les fichiers de la vue
include_once __DIR__ . '/../src/includes/header.php';
include_once __DIR__ . '/../templates/admin_manage_services.php';
include_once __DIR__ . '/../src/includes/footer.php';
?>