<?php
require_once __DIR__ . '/../../config/db.php';

class Facture {
    public static function create($reservation_id, $montant_ht, $tva, $montant_ttc) {
        $pdo = getPDO();
        $sql = "INSERT INTO factures (reservation_id, montant_ht, tva, montant_ttc, date_emission, statut_paiement) VALUES (?, ?, ?, ?, CURDATE(), 'En attente')";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$reservation_id, $montant_ht, $tva, $montant_ttc]);
    }

    public static function findByReservationId($reservation_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM factures WHERE reservation_id = ?');
        $stmt->execute([$reservation_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>