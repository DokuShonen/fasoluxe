<?php
require_once __DIR__ . '/../../config/db.php';

class TypeChambre {
    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query('SELECT * FROM types_chambre ORDER BY nom');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>