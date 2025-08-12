<?php
require_once __DIR__ . '/../src/includes/auth_admin.php';
require_once __DIR__ . '/../src/models/Client.php';

$action = $_REQUEST['action'] ?? null;
$id = $_REQUEST['id'] ?? null;

// Traitement des actions POST (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    // Gerer la checkbox: si non cochee, elle n'est pas envoyee dans $_POST
    $data['carte_fidelite'] = isset($data['carte_fidelite']) ? 1 : 0;

    if ($action === 'update' && $id) {
        Client::update($id, $data);
    }
    header('Location: manage_clients.php');
    exit();
}

// Traitement des actions GET (Delete)
if ($action === 'delete' && $id) {
    Client::delete($id);
    header('Location: manage_clients.php');
    exit();
}

// Preparation pour l'affichage
$clients = Client::getAll();

$is_editing = false;
$client_to_edit = [];

if ($action === 'edit' && $id) {
    $is_editing = true;
    $client_to_edit = Client::findById($id);
}

// Inclure les fichiers de la vue
include_once __DIR__ . '/../src/includes/header.php';
include_once __DIR__ . '/../templates/admin_manage_clients.php';
include_once __DIR__ . '/../src/includes/footer.php';
?>