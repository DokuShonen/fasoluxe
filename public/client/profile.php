<?php
require_once __DIR__ . '/../../src/includes/auth_client.php';
require_once __DIR__ . '/../../src/models/Client.php';

$client_id = $current_client['id'];
$client = Client::findById($client_id);

if (!$client) {
    // Devrait normalement ne jamais arriver si auth_client.php fonctionne
    header('Location: ../login.php');
    exit();
}

// Traitement des mises a jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
        // Traitement du changement de mot de passe
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        if (!password_verify($current_password, $client['mot_de_passe'])) {
            $_SESSION['error_message'] = "Le mot de passe actuel est incorrect.";
        } elseif ($new_password !== $confirm_new_password) {
            $_SESSION['error_message'] = "Les nouveaux mots de passe ne correspondent pas.";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            if (Client::updatePassword($client_id, $hashed_password)) {
                $_SESSION['success_message'] = "Votre mot de passe a ete mis a jour avec succes.";
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de la mise a jour du mot de passe.";
            }
        }
    } else {
        // Traitement de la mise a jour des informations personnelles
        $data = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone']
        ];

        // Conserver la classification, carte_fidelite et reduction existantes
        $data['classification'] = $client['classification'];
        $data['carte_fidelite'] = $client['carte_fidelite'];
        $data['reduction'] = $client['reduction'];

        if (Client::update($client_id, $data)) {
            $_SESSION['success_message'] = "Vos informations ont ete mises a jour avec succes.";
            // Mettre a jour la session de l'utilisateur
            $_SESSION['user']['nom'] = $data['prenom'] . ' ' . $data['nom'];
            $_SESSION['user']['email'] = $data['email'];
        } else {
            $_SESSION['error_message'] = "Une erreur est survenue lors de la mise a jour de vos informations.";
        }
    }
    header('Location: profile.php');
    exit();
}

// Inclure l'entete
include_once __DIR__ . '/../../src/includes/header.php';

// Inclure la vue
include_once __DIR__ . '/../../templates/client_profile.php';

// Inclure le pied de page
include_once __DIR__ . '/../../src/includes/footer.php';
?>