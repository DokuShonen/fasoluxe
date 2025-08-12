<?php
require_once __DIR__ . '/../../config/db.php';

class Service {
    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query('SELECT s.*, h.nom as hotel_nom FROM services s JOIN hotels h ON s.hotel_id = h.id ORDER BY h.nom, s.nom');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM services WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $pdo = getPDO();
        $sql = "INSERT INTO services (hotel_id, nom, description, tarif) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['hotel_id'], $data['nom'], $data['description'], $data['tarif']]);
    }

    public static function update($id, $data) {
        $pdo = getPDO();
        $sql = "UPDATE services SET hotel_id = ?, nom = ?, description = ?, tarif = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['hotel_id'], $data['nom'], $data['description'], $data['tarif'], $id]);
    }

    public static function delete($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('DELETE FROM services WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>