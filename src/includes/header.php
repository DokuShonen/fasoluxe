<?php require_once __DIR__ . '/../../config/db.php'; if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FasoLuxe Hotels</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><a href="<?php echo BASE_URL; ?>public/index.php">FasoLuxe Hotels</a></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>public/index.php">Accueil</a></li>
                    <li><a href="<?php echo BASE_URL; ?>public/hotels.php">Nos Hotels</a></li>
                    <?php if (isset($_SESSION['user'])):
                        $role_path = '';
                        switch ($_SESSION['user']['role']) {
                            case 'Admin':
                                $role_path = 'admin/';
                                break;
                            case 'Reception':
                                $role_path = 'reception/';
                                break;
                            case 'Client':
                                $role_path = 'client/';
                                break;
                        }
                    ?>
                        <li><a href="<?php echo BASE_URL; ?><?php echo $role_path; ?>dashboard.php">Mon Espace</a></li>
                        <li><a href="<?php echo BASE_URL; ?>public/logout.php">Deconnexion</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>public/login.php">Connexion</a></li>
                        <li><a href="<?php echo BASE_URL; ?>public/register.php">S'inscrire</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>