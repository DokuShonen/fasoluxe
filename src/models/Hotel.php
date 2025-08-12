<?php
require_once __DIR__ . '/../../config/db.php';

class Hotel {
    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query('SELECT * FROM hotels ORDER BY ville, nom');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM hotels WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getChambres($hotel_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT c.*, tc.nom as type_nom FROM chambres c JOIN types_chambre tc ON c.type_chambre_id = tc.id WHERE c.hotel_id = ? ORDER BY c.tarif_nuit');
        $stmt->execute([$hotel_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getServices($hotel_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM services WHERE hotel_id = ? ORDER BY nom');
        $stmt->execute([$hotel_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $pdo = getPDO();
        $sql = "INSERT INTO hotels (nom, ville, adresse, description, categorie, email, site_web) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['nom'], $data['ville'], $data['adresse'], $data['description'], $data['categorie'], $data['email'], $data['site_web']]);
    }

    public static function update($id, $data) {
        $pdo = getPDO();
        $sql = "UPDATE hotels SET nom = ?, ville = ?, adresse = ?, description = ?, categorie = ?, email = ?, site_web = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['nom'], $data['ville'], $data['adresse'], $data['description'], $data['categorie'], $data['email'], $data['site_web'], $id]);
    }

    public static function delete($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('DELETE FROM hotels WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>