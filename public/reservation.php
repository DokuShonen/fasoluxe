<?php
require_once __DIR__ . '/../src/models/Chambre.php';
require_once __DIR__ . '/../src/models/Client.php';
require_once __DIR__ . '/../src/models/Reservation.php';
require_once __DIR__ . '/../src/controllers/EmailSender.php';

// Demarrer la session pour stocker les messages
session_start();

// --- TRAITEMENT DU FORMULAIRE (METHODE POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperation des donnees du formulaire
    $chambre_id = $_POST['chambre_id'];
    $date_arrivee = $_POST['date_arrivee'];
    $date_depart = $_POST['date_depart'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    // 1. Trouver ou creer le client
    $client_id = Client::findOrCreate($nom, $prenom, $email, $telephone);

    // 2. Creer la reservation
    $numero_confirmation = Reservation::create($client_id, $chambre_id, $date_arrivee, $date_depart);

    // 3. Rediriger vers la page de confirmation
    if ($numero_confirmation) {
        $_SESSION['confirmation_id'] = $numero_confirmation;

        // Recuperer les details complets de la reservation pour l'email
        $reservation_details_for_email = Reservation::findByConfirmationNumber($numero_confirmation);
        if ($reservation_details_for_email) {
            $reservation_details_for_email['montant_ttc'] = $prix_total; // Ajouter le prix total calcule
        }

        // Envoyer l'email de confirmation
        $subject = "Votre reservation FasoLuxe Hotels est confirmee ! (#" . $numero_confirmation . ")";
        $body = EmailSender::getConfirmationEmailBody($reservation_details_for_email);
        EmailSender::sendConfirmationEmail($email, $subject, $body);

        header('Location: /fasoluxe_project/public/confirmation.php');
        exit();
    } else {
        // Gerer l'erreur de creation
        $_SESSION['error_message'] = "Une erreur est survenue lors de la creation de votre reservation.";
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET)); // Redirige vers le formulaire
        exit();
    }
}

// --- AFFICHAGE DU FORMULAIRE (METHODE GET) ---

// Recuperation des parametres de l'URL
$chambre_id = $_GET['chambre_id'] ?? null;
$date_arrivee = $_GET['arrivee'] ?? null;
$date_depart = $_GET['depart'] ?? null;

// Validation simple
if (!$chambre_id || !$date_arrivee || !$date_depart) {
    header('Location: /fasoluxe_project/public/index.php');
    exit();
}

// Recuperer les details de la chambre
$chambre = Chambre::findById($chambre_id);
if (!$chambre) {
    header('Location: /fasoluxe_project/public/index.php');
    exit();
}

// Calcul du nombre de nuits et du prix total
$datetime1 = new DateTime($date_arrivee);
$datetime2 = new DateTime($date_depart);
$interval = $datetime1->diff($datetime2);
$nb_nuits = $interval->days;
$prix_total = $nb_nuits * $chambre['tarif_nuit'];

// Inclure l'entete
include_once __DIR__ . '/../src/includes/header.php';

// Inclure la vue du formulaire de reservation
include_once __DIR__ . '/../templates/reservation_form.php';

// Inclure le pied de page
include_once __DIR__ . '/../src/includes/footer.php';
?>