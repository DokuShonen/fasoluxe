<?php
require_once __DIR__ . '/../src/models/Client.php';
session_start();

// Si l'utilisateur est deja connecte, le rediriger
if (isset($_SESSION['user'])) {
    header('Location: /fasoluxe_project/public/client/dashboard.php');
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? null;
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation simple
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error_message'] = "Tous les champs obligatoires doivent etre remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Adresse email invalide.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            if (Client::register($nom, $prenom, $email, $telephone, $password)) {
                $_SESSION['success_message'] = "Votre compte a ete cree avec succes. Vous pouvez maintenant vous connecter.";
            header('Location: /fasoluxe_project/public/login.php');
                exit();
            } else {
                $_SESSION['error_message'] = "Cet email est deja utilise ou une erreur est survenue lors de l'enregistrement.";
            }
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur de base de donnees: " . $e->getMessage();
        }
    }
    header('Location: /fasoluxe_project/public/register.php');
    exit();
}

// Affichage du formulaire
include_once __DIR__ . '/../src/includes/header.php';
include_once __DIR__ . '/../templates/registration_form.php';
include_once __DIR__ . '/../src/includes/footer.php';
?>