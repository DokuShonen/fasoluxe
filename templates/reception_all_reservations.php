<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/reception_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Toutes les Reservations</h2>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Confirmation #</th>
                        <th>Client</th>
                        <th>Hotel</th>
                        <th>Chambre</th>
                        <th>Arrivee</th>
                        <th>Depart</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($all_reservations)): ?>
                        <tr>
                            <td colspan="8">Aucune reservation trouvee pour cet hotel.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($all_reservations as $res): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($res['numero_confirmation']); ?></td>
                                <td><?php echo htmlspecialchars($res['client_prenom'] . ' ' . $res['client_nom']); ?></td>
                                <td><?php echo htmlspecialchars($res['hotel_nom']); ?></td>
                                <td><?php echo htmlspecialchars($res['type_chambre_nom'] . ' (' . $res['numero_chambre'] . ')'); ?></td>
                                <td><?php echo htmlspecialchars($res['date_arrivee']); ?></td>
                                <td><?php echo htmlspecialchars($res['date_depart']); ?></td>
                                <td><span class="status-<?php echo strtolower($res['statut']); ?>"><?php echo htmlspecialchars($res['statut']); ?></span></td>
                                <td>
                                    <a href="#" class="btn-small">Details</a>
                                    <?php if ($res['statut'] === 'Confirmee'): ?>
                                        <a href="<?php echo BASE_URL; ?>reception/cancel_reservation.php?id=<?php echo $res['id']; ?>" class="btn-small btn-cancel" onclick="return confirm('Etes-vous sur de vouloir annuler cette reservation ?');">Annuler</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>