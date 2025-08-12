<?php
require_once __DIR__ . '/../../config/db.php';

class User {
    public static function attemptLogin($email, $password) {
        $pdo = getPDO();

        // 1. Verifier dans la table des utilisateurs (personnel)
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verifier si le mot de passe est en texte clair (pour les utilisateurs d'exemple)
            if ($user['mot_de_passe'] === $password) {
                // Hasher le mot de passe et le mettre a jour dans la base de donnees
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $pdo->prepare('UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?');
                $update_stmt->execute([$hashed_password, $user['id']]);
                $user['mot_de_passe'] = $hashed_password; // Mettre a jour l'objet user en memoire
            }

            if (password_verify($password, $user['mot_de_passe'])) {
                // C'est un membre du personnel
                return [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'role' => $user['role'], // 'Admin' ou 'Reception'
                'hotel_id' => $user['hotel_id'] ?? null // Assure que la cle existe, meme si la valeur est NULL
            ];
            }
        }

        // 2. Verifier dans la table des clients
        $stmt = $pdo->prepare('SELECT * FROM clients WHERE email = ?');
        $stmt->execute([$email]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($client) {
            // Verifier si le mot de passe est en texte clair (pour les clients crees via findOrCreate)
            // Note: Les clients crees via register() auront deja un mot de passe hashe
            if ($client['mot_de_passe'] === $password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $pdo->prepare('UPDATE clients SET mot_de_passe = ? WHERE id = ?');
                $update_stmt->execute([$hashed_password, $client['id']]);
                $client['mot_de_passe'] = $hashed_password;
            }

            if (password_verify($password, $client['mot_de_passe'])) {
                // C'est un client
                return [
                    'id' => $client['id'],
                    'nom' => $client['prenom'] . ' ' . $client['nom'],
                    'email' => $client['email'],
                    'role' => 'Client'
                ];
            }
        }

        // Echec de la connexion
        return false;
    }
}
?>