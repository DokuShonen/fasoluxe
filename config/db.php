<?php
// Determine the base URL dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$project_path = dirname(dirname($script_name)); // Assumes config is in a subfolder of the project root
$base_url = rtrim($protocol . $host . $project_path, '/') . '/';

define('BASE_URL', $base_url);

define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Utilisateur par defaut de WampServer
define('DB_PASS', ''); // Mot de passe par defaut de WampServer (vide)
define('DB_NAME', 'fasoluxe_db'); // Nom de la base de donnees locale

// Connexion a la base de donnees
function getPDO() {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}
?>