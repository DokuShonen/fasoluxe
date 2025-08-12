<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifier si l'utilisateur est connecte et a le bon role
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Reception', 'Admin'])) {
    $_SESSION['error_message'] = "Acces non autorise.";
    header('Location: ../login.php');
    exit();
}

// Mettre les informations de l'utilisateur dans une variable facile a utiliser
$current_user = $_SESSION['user'];
?>