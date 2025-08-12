<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifier si l'utilisateur est connecte et si c'est bien un client
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Client') {
    // Stocker un message d'erreur
    $_SESSION['error_message'] = "Vous devez etre connecte en tant que client pour acceder a cette page.";
    // Rediriger vers la page de connexion
    header('Location: ../login.php');
    exit();
}

// Mettre les informations de l'utilisateur dans une variable facile a utiliser
$current_client = $_SESSION['user'];
?>