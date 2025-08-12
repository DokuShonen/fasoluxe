<?php
require_once __DIR__ . '/../../config/db.php';

class Reservation {
    public static function create($client_id, $chambre_id, $date_arrivee, $date_depart) {
        $pdo = getPDO();

        // Generer un numero de confirmation unique
        $numero_confirmation = 'FSLX-' . strtoupper(bin2hex(random_bytes(6)));

        $sql = "INSERT INTO reservations (client_id, chambre_id, date_arrivee, date_depart, numero_confirmation, nombre_personnes) VALUES (?, ?, ?, ?, ?, 1)"; // Nombre de personnes en dur pour l'instant
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$client_id, $chambre_id, $date_arrivee, $date_depart, $numero_confirmation]);
            return $numero_confirmation;
        } catch (PDOException $e) {
            // Gerer les erreurs, par exemple si le numero de confirmation n'est pas unique
            // Log l'erreur $e->getMessage();
            return false;
        }
    }

    public static function findByConfirmationNumber($numero) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('
            SELECT 
                r.numero_confirmation, r.date_arrivee, r.date_depart,
                c.nom as client_nom, c.prenom as client_prenom, c.email as client_email, c.telephone as client_telephone,
                ch.equipements, ch.tarif_nuit, ch.numero_chambre,
                tc.nom as type_chambre_nom,
                h.nom as hotel_nom, h.ville as hotel_ville, h.adresse as hotel_adresse
            FROM reservations r
            JOIN clients c ON r.client_id = c.id
            JOIN chambres ch ON r.chambre_id = ch.id
            JOIN types_chambre tc ON ch.type_chambre_id = tc.id
            JOIN hotels h ON ch.hotel_id = h.id
            WHERE r.numero_confirmation = ?
        ');
        $stmt->execute([$numero]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByClientId($client_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('
            SELECT 
                r.id, r.numero_confirmation, r.date_arrivee, r.date_depart, r.statut,
                h.nom as hotel_nom, tc.nom as type_chambre_nom,
                ch.tarif_nuit, c.reduction as client_reduction
            FROM reservations r
            JOIN clients c ON r.client_id = c.id
            JOIN chambres ch ON r.chambre_id = ch.id
            JOIN types_chambre tc ON ch.type_chambre_id = tc.id
            JOIN hotels h ON ch.hotel_id = h.id
            WHERE r.client_id = ?
            ORDER BY r.date_arrivee DESC
        ');
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getReservationsEnCoursByClientId($client_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT 
                r.id, r.numero_confirmation, r.date_arrivee, r.date_depart, r.statut,
                ch.tarif_nuit, c.reduction as client_reduction
            FROM reservations r
            JOIN clients c ON r.client_id = c.id
            JOIN chambres ch ON r.chambre_id = ch.id
            WHERE r.client_id = ? AND r.statut = 'En cours'
        ");
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDailyActivity($hotel_id, $date) {
        $pdo = getPDO();

        $sql = "
            SELECT 
                r.id, r.statut, r.date_arrivee, r.date_depart,
                c.nom as client_nom, c.prenom as client_prenom,
                ch.numero_chambre, tc.nom as type_chambre_nom
            FROM reservations r
            JOIN clients c ON r.client_id = c.id
            JOIN chambres ch ON r.chambre_id = ch.id
            JOIN types_chambre tc ON ch.type_chambre_id = tc.id
            JOIN hotels h ON ch.hotel_id = h.id
            WHERE ch.hotel_id = :hotel_id AND (
                (r.date_arrivee = :current_date AND r.statut = :statusConfirmee) OR 
                (r.date_depart = :current_date AND r.statut = :statusEnCours) OR
                (r.date_arrivee < :current_date AND r.date_depart > :current_date AND r.statut = :statusEnCours)
            )
            ORDER BY r.date_arrivee, r.date_depart
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':hotel_id' => $hotel_id,
            ':current_date' => $date,
            ':statusConfirmee' => 'Confirmee',
            ':statusEnCours' => 'En cours'
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($reservation_id, $new_status) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('UPDATE reservations SET statut = ? WHERE id = ?');
        return $stmt->execute([$new_status, $reservation_id]);
    }

    public static function getIdByConfirmationNumber($numero) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT id FROM reservations WHERE numero_confirmation = ?');
        $stmt->execute([$numero]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    public static function getOccupancyData($start_date, $end_date, $hotel_id = null) {
        $pdo = getPDO();

        $statusConfirmee = 'Confirmee';
        $statusEnCours = 'En cours';
        $statusTerminee = 'Terminee';

        $sql = "
            SELECT 
                r.date_arrivee, r.date_depart,
                ch.numero_chambre, tc.nom as type_chambre_nom,
                h.nom as hotel_nom
            FROM reservations r
            JOIN chambres ch ON r.chambre_id = ch.id
            JOIN types_chambre tc ON ch.type_chambre_id = tc.id
            JOIN hotels h ON ch.hotel_id = h.id
            WHERE r.statut IN ('Confirmee', 'En cours')
            AND r.date_arrivee <= :end_date AND r.date_depart >= :start_date
        ";

        $params = [
            ':start_date' => $start_date,
            ':end_date' => $end_date
        ];

        if ($hotel_id) {
            $sql .= " AND h.id = :hotel_id";
            $params[':hotel_id'] = $hotel_id;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getAllReservationsByHotelId($hotel_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('
            SELECT 
                r.id, r.numero_confirmation, r.date_arrivee, r.date_depart, r.statut,
                c.nom as client_nom, c.prenom as client_prenom,
                ch.numero_chambre, tc.nom as type_chambre_nom,
                h.nom as hotel_nom
            FROM reservations r
            JOIN clients c ON r.client_id = c.id
            JOIN chambres ch ON r.chambre_id = ch.id
            JOIN types_chambre tc ON ch.type_chambre_id = tc.id
            JOIN hotels h ON ch.hotel_id = h.id
            WHERE h.id = ?
            ORDER BY r.date_arrivee DESC
        ');
        $stmt->execute([$hotel_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByIdWithDetails($reservation_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('
            SELECT 
                r.id, r.numero_confirmation, r.date_arrivee, r.date_depart, r.statut,
                c.nom as client_nom, c.prenom as client_prenom, c.email as client_email, c.telephone as client_telephone,
                ch.equipements, ch.tarif_nuit, ch.numero_chambre,
                tc.nom as type_chambre_nom,
                h.nom as hotel_nom, h.ville as hotel_ville, h.adresse as hotel_adresse,
                c.reduction as client_reduction
            FROM reservations r
            JOIN clients c ON r.client_id = c.id
            JOIN chambres ch ON r.chambre_id = ch.id
            JOIN types_chambre tc ON ch.type_chambre_id = tc.id
            JOIN hotels h ON ch.hotel_id = h.id
            WHERE r.id = ?
        ');
        $stmt->execute([$reservation_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
?>