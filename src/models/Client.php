<?php
require_once __DIR__ . '/../../config/db.php';

class Client {
    public static function findOrCreate($nom, $prenom, $email, $telephone) {
        $pdo = getPDO();

        // Verifier si le client existe deja
        $stmt = $pdo->prepare('SELECT id FROM clients WHERE email = ?');
        $stmt->execute([$email]);
        $client = $stmt->fetch();

        if ($client) {
            return $client['id'];
        } else {
            // Creer un nouveau client (avec un mot de passe temporaire, a ameliorer)
            $password = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT); // Mot de passe aleatoire
            $stmt = $pdo->prepare('INSERT INTO clients (nom, prenom, email, telephone, mot_de_passe, carte_fidelite, reduction) VALUES (?, ?, ?, ?, ?, 0, 0.00)');
            $stmt->execute([$nom, $prenom, $email, $telephone, $password]);
            return $pdo->lastInsertId();
        }
    }

    public static function register($nom, $prenom, $email, $telephone, $password) {
        $pdo = getPDO();

        // Verifier si l'email existe deja
        $stmt = $pdo->prepare('SELECT id FROM clients WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return false; // Email deja utilise
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO clients (nom, prenom, email, telephone, mot_de_passe, classification, carte_fidelite, reduction) VALUES (?, ?, ?, ?, ?, ?, 0, 0.00)');
        return $stmt->execute([$nom, $prenom, $email, $telephone, $hashed_password, 'Occasionnel']);
    }

    public static function getAll() {
        $pdo = getPDO();
        $stmt = $pdo->query('SELECT * FROM clients ORDER BY nom, prenom');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM clients WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data) {
        $pdo = getPDO();
        $sql = "UPDATE clients SET nom = ?, prenom = ?, email = ?, telephone = ?, classification = ?, carte_fidelite = ?, reduction = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$data['nom'], $data['prenom'], $data['email'], $data['telephone'], $data['classification'], $data['carte_fidelite'], $data['reduction'], $id]);
    }

    public static function delete($id) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('DELETE FROM clients WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function updatePassword($id, $hashed_password) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('UPDATE clients SET mot_de_passe = ? WHERE id = ?');
        return $stmt->execute([$hashed_password, $id]);
    }
}
?>