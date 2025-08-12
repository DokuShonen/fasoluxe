<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/reception_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Activite du Jour - <?php echo date('d/m/Y'); ?></h2>

        <!-- Section Arrivees -->
        <h3>Arrivees prevues</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Client</th><th>Chambre</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach ($arrivees as $res): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($res['client_prenom'] . ' ' . $res['client_nom']); ?></td>
                            <td><?php echo htmlspecialchars($res['type_chambre_nom'] . ' (' . $res['numero_chambre'] . ')'); ?></td>
                            <td><a href="dashboard.php?action=checkin&id=<?php echo $res['id']; ?>" class="btn-small">Check-in</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($arrivees)) echo '<tr><td colspan="3">Aucune arrivee prevue.</td></tr>'; ?>
                </tbody>
            </table>
        </div>

        <!-- Section Departs -->
        <h3>Departs prevus</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Client</th><th>Chambre</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach ($departs as $res): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($res['client_prenom'] . ' ' . $res['client_nom']); ?></td>
                            <td><?php echo htmlspecialchars($res['type_chambre_nom'] . ' (' . $res['numero_chambre'] . ')'); ?></td>
                            <td><a href="<?php echo BASE_URL; ?>reception/dashboard.php?action=checkout&id=<?php echo $res['id']; ?>" class="btn-small btn-cancel">Check-out</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($departs)) echo '<tr><td colspan="3">Aucun depart prevu.</td></tr>'; ?>
                </tbody>
            </table>
        </div>

        <!-- Section Clients Presents -->
        <h3>Clients actuellement a l'hotel</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Client</th><th>Chambre</th><th>Depart prevu</th></tr></thead>
                <tbody>
                    <?php foreach ($occupants as $res): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($res['client_prenom'] . ' ' . $res['client_nom']); ?></td>
                            <td><?php echo htmlspecialchars($res['type_chambre_nom'] . ' (' . $res['numero_chambre'] . ')'); ?></td>
                            <td><?php echo htmlspecialchars($res['date_depart']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($occupants)) echo '<tr><td colspan="3">Aucun client a l\'hotel actuellement.</td></tr>'; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>