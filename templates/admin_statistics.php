<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/admin_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Statistiques et Taux d'Occupation</h2>

        <div class="form-container">
            <h3>Filtrer les donnees</h3>
            <form action="<?php echo BASE_URL; ?>admin/statistics.php" method="GET">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="start_date">Date de debut</label>
                        <input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Date de fin</label>
                        <input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hotel_id">Hotel</label>
                        <select name="hotel_id">
                            <option value="">Tous les hotels</option>
                            <?php foreach ($hotels as $hotel): ?>
                                <option value="<?php echo $hotel['id']; ?>" <?php echo ($selected_hotel_id == $hotel['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($hotel['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn">Afficher les statistiques</button>
            </form>
        </div>

        <h3>Taux d'Occupation par Hotel</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Chambres Totales</th>
                        <th>Nuits Reservees</th>
                        <th>Taux d'Occupation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($occupancy_stats)): ?>
                        <tr><td colspan="4">Aucune donnee d'occupation pour la periode selectionnee.</td></tr>
                    <?php else: ?>
                        <?php foreach ($occupancy_stats as $hotel_name => $data): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($hotel_name); ?></td>
                                <td><?php echo $data['total_chambres']; ?></td>
                                <td><?php echo $data['nuits_reservees']; ?></td>
                                <td><?php echo number_format($data['taux_occupation'], 2); ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h3>Planning des Reservations</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Chambre</th>
                        <th>Type</th>
                        <th>Arrivee</th>
                        <th>Depart</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($occupancy_data)): ?>
                        <tr><td colspan="5">Aucune reservation pour la periode selectionnee.</td></tr>
                    <?php else: ?>
                        <?php foreach ($occupancy_data as $reservation): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reservation['hotel_nom']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['numero_chambre']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['type_chambre_nom']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['date_arrivee']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['date_depart']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>