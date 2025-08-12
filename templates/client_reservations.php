<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/client_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Mes Reservations</h2>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Chambre</th>
                        <th>Arrivee</th>
                        <th>Depart</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reservations)): ?>
                        <tr>
                            <td colspan="6">Vous n'avez aucune reservation pour le moment.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reservations as $res): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($res['hotel_nom']); ?></td>
                                <td><?php echo htmlspecialchars($res['type_chambre_nom']); ?></td>
                                <td><?php echo htmlspecialchars($res['date_arrivee']); ?></td>
                                <td><?php echo htmlspecialchars($res['date_depart']); ?></td>
                                <td><span class="status-<?php echo strtolower($res['statut']); ?>"><?php echo htmlspecialchars($res['statut']); ?></span></td>
                                <td>
                                    <a href="reservation_details.php?id=<?php echo $res['id']; ?>" class="btn-small">Details</a>
                                    <?php if ($res['statut'] === 'Confirmee'): ?>
                                        <a href="<?php echo BASE_URL; ?>client/cancel_reservation.php?id=<?php echo $res['id']; ?>" class="btn-small btn-cancel" onclick="return confirm('Etes-vous sur de vouloir annuler cette reservation ?');">Annuler</a>
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