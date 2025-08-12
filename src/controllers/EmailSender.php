<?php

class EmailSender {
    public static function sendConfirmationEmail($to, $subject, $body) {
        // Pour un environnement de developpement, vous pouvez rediriger les emails vers un fichier ou un service de test
        // Pour la production, assurez-vous que votre serveur est configure pour envoyer des emails (ex: Postfix, Sendmail)
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: FasoLuxe Hotels <no-reply@fasoluxe.com>' . "\r\n";

        // Utilisation de la fonction mail() de PHP
        // En production, il est fortement recommande d'utiliser une bibliotheque comme PHPMailer ou Symfony Mailer
        // avec un service SMTP pour une meilleure fiabilite et delivrabilite.
        return mail($to, $subject, $body, $headers);
    }

    public static function getConfirmationEmailBody($reservation_details) {
        $body = '
            <html>
            <head>
                <title>Confirmation de votre reservation FasoLuxe Hotels</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { width: 80%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                    h2 { color: #0d2d52; }
                    .confirmation-number { font-weight: bold; color: #c5a47e; font-size: 1.2em; }
                    .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .details-table th, .details-table td { border: 1px solid #eee; padding: 8px; text-align: left; }
                    .details-table th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Confirmation de votre reservation</h2>
                    <p>Cher(e) <strong>' . htmlspecialchars($reservation_details['client_prenom']) . ' ' . htmlspecialchars($reservation_details['client_nom']) . '</strong>,</p>
                    <p>Nous avons bien recu votre reservation chez FasoLuxe Hotels. Voici les details :</p>
                    
                    <p><strong>Numero de reservation :</strong> <span class="confirmation-number">' . htmlspecialchars($reservation_details['numero_confirmation']) . '</span></p>

                    <table class="details-table">
                        <tr><th>Hotel</th><td>' . htmlspecialchars($reservation_details['hotel_nom']) . ' (' . htmlspecialchars($reservation_details['hotel_ville']) . ')</td></tr>
                        <tr><th>Chambre</th><td>' . htmlspecialchars($reservation_details['type_chambre_nom']) . ' (' . htmlspecialchars($reservation_details['numero_chambre']) . ')</td></tr>
                        <tr><th>Arrivee</th><td>' . htmlspecialchars($reservation_details['date_arrivee']) . '</td></tr>
                        <tr><th>Depart</th><td>' . htmlspecialchars($reservation_details['date_depart']) . '</td></tr>
                        <tr><th>Tarif par nuit</th><td>' . number_format($reservation_details['tarif_nuit'], 0, ',', ' ') . ' FCFA</td></tr>
                        <tr><th>Total estime</th><td>' . number_format($reservation_details['montant_ttc'], 0, ',', ' ') . ' FCFA</td></tr>
                    </table>

                    <p>Nous vous remercions de votre confiance et avons hate de vous accueillir.</p>
                    <p>Cordialement,<br>L\'equipe FasoLuxe Hotels</p>
                </div>
            </body>
            </html>
        ';
        return $body;
    }
}
?>