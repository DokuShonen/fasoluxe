<?php
require_once __DIR__ . '/../src/includes/auth_admin.php';

// Inclure l'entete
include_once __DIR__ . '/../src/includes/header.php';
?>

<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/admin_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Tableau de Bord Administrateur</h2>
        <p>Bonjour, <strong><?php echo htmlspecialchars($current_admin['nom']); ?></strong> !</p>
        <p>Bienvenue dans l'interface d'administration. Utilisez le menu lateral pour gerer les hotels, les chambres, les services et les clients.</p>
    </main>
</div>

<?php
// Inclure le pied de page
include_once __DIR__ . '/../src/includes/footer.php';
?>