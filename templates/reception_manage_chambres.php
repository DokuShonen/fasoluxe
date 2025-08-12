<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/reception_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Gestion des Chambres de l'hotel <?php echo htmlspecialchars($hotel_name); ?></h2>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Equipements</th>
                        <th>Tarif par Nuit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($chambres)): ?>
                        <tr>
                            <td colspan="5">Aucune chambre trouvee pour cet hotel.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($chambres as $chambre): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($chambre['numero_chambre']); ?></td>
                                <td><?php echo htmlspecialchars($chambre['type_nom']); ?></td>
                                <td><?php echo htmlspecialchars($chambre['description'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($chambre['equipements']); ?></td>
                                <td><?php echo number_format($chambre['tarif_nuit'], 0, ',', ' '); ?> FCFA</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>