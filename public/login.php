<?php
require_once __DIR__ . '/../src/models/User.php';
session_start();

// Si l'utilisateur est deja connecte, le rediriger
if (isset($_SESSION['user'])) {
    // Redirection basee sur le role
    $role = $_SESSION['user']['role'];
    if ($role === 'Admin') header('Location: /fasoluxe_project/admin/dashboard.php');
    elseif ($role === 'Reception') header('Location: /fasoluxe_project/public/reception/dashboard.php');
    else header('Location: /fasoluxe_project/public/client/dashboard.php');
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = User::attemptLogin($email, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        // Redirection basee sur le role
        if ($user['role'] === 'Admin') header('Location: /fasoluxe_project/admin/dashboard.php');
        elseif ($user['role'] === 'Reception') header('Location: /fasoluxe_project/public/reception/dashboard.php');
        else header('Location: /fasoluxe_project/public/client/dashboard.php');
        exit();
    } else {
        $_SESSION['error_message'] = "Email ou mot de passe incorrect.";
        header('Location: login.php');
        exit();
    }
}

// Affichage du formulaire
include_once __DIR__ . '/../src/includes/header.php';
include_once __DIR__ . '/../templates/login_form.php';
include_once __DIR__ . '/../src/includes/footer.php';
?>