<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifier si l'utilisateur est connecte et si c'est bien un Admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
    $_SESSION['error_message'] = "Acces reserve aux administrateurs.";
    header('Location: ../public/login.php');
    exit();
}

$current_admin = $_SESSION['user'];
?>