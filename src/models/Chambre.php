<?php
require_once __DIR__ . '/../../config/db.php';

class Chambre {
    public static function findById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('
            SELECT c.*, h.nom as hotel_nom, h.ville as hotel_ville, tc.nom as type_nom
            FROM chambres c
            JOIN hotels h ON c.hotel_id = h.id
            JOIN types_chambre tc ON c.type_chambre_id = tc.id
            WHERE c.id = ?
        ');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findAvailable($date_arrivee, $date_depart, $ville, $personnes) {
        $pdo = getPDO();

        // La requete de base pour trouver les chambres qui ne sont PAS reservees pendant la periode donnee
        $sql = "
            SELECT c.*, h.nom as hotel_nom, h.ville as hotel_ville, tc.nom as type_nom
            FROM chambres c
            JOIN hotels h ON c.hotel_id = h.id
            JOIN types_chambre tc ON c.type_chambre_id = tc.id
            WHERE c.id NOT IN (
                SELECT chambre_id FROM reservations
                WHERE statut = 'Confirmee' AND (
                    (date_arrivee <= :date_depart AND date_depart >= :date_arrivee)
                )
            )
        ";

        $params = [
            ':date_arrivee' => $date_arrivee,
            ':date_depart' => $date_depart
        ];

        // Ajouter le filtre de ville si specifie
        if (!empty($ville)) {
            $sql .= " AND h.ville = :ville";
            $params[':ville'] = $ville;
        }
        
        // TODO: Ajouter une logique pour le nombre de personnes

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query('SELECT c.*, h.nom as hotel_nom, tc.nom as type_nom FROM chambres c JOIN hotels h ON c.hotel_id = h.id JOIN types_chambre tc ON c.type_chambre_id = tc.id ORDER BY h.nom, c.numero_chambre');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllByHotelId($hotel_id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT c.*, h.nom as hotel_nom, tc.nom as type_nom FROM chambres c JOIN hotels h ON c.hotel_id = h.id JOIN types_chambre tc ON c.type_chambre_id = tc.id WHERE c.hotel_id = ? ORDER BY c.numero_chambre');
        $stmt->execute([$hotel_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $pdo = getPDO();
        $sql = "INSERT INTO chambres (hotel_id, type_chambre_id, numero_chambre, description, equipements, tarif_nuit) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['hotel_id'], $data['type_chambre_id'], $data['numero_chambre'], $data['description'], $data['equipements'], $data['tarif_nuit']]);
    }

    public static function update($id, $data) {
        $pdo = getPDO();
        $sql = "UPDATE chambres SET hotel_id = ?, type_chambre_id = ?, numero_chambre = ?, description = ?, equipements = ?, tarif_nuit = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['hotel_id'], $data['type_chambre_id'], $data['numero_chambre'], $data['description'], $data['equipements'], $data['tarif_nuit'], $id]);
    }

    public static function delete($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('DELETE FROM chambres WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>