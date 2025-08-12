<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/admin_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Gestion des Services</h2>

        <!-- Formulaire d'ajout/modification -->
        <div class="form-container">
            <h3><?php echo $is_editing ? 'Modifier le service' : 'Ajouter un nouveau service'; ?></h3>
            <form action="manage_services.php" method="POST">
                <?php if ($is_editing): ?>
                    <input type="hidden" name="id" value="<?php echo $service_to_edit['id']; ?>">
                <?php endif; ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="hotel_id">Hotel</label>
                        <select name="hotel_id" required>
                            <?php foreach ($hotels as $hotel): ?>
                                <option value="<?php echo $hotel['id']; ?>" <?php echo (isset($service_to_edit['hotel_id']) && $service_to_edit['hotel_id'] == $hotel['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($hotel['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom du Service</label>
                        <input type="text" name="nom" value="<?php echo $service_to_edit['nom'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tarif">Tarif (FCFA)</label>
                        <input type="number" name="tarif" step="0.01" value="<?php echo $service_to_edit['tarif'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea name="description" rows="3"><?php echo $service_to_edit['description'] ?? ''; ?></textarea>
                    </div>
                </div>
                <button type="submit" name="action" value="<?php echo $is_editing ? 'update' : 'create'; ?>" class="btn">
                    <?php echo $is_editing ? 'Mettre a jour' : 'Ajouter le service'; ?>
                </button>
                <?php if ($is_editing): ?>
                    <a href="manage_services.php" class="btn btn-cancel">Annuler l'edition</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Liste des services -->
        <h3>Liste des Services Existants</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Hotel</th><th>Nom</th><th>Tarif</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($service['hotel_nom']); ?></td>
                            <td><?php echo htmlspecialchars($service['nom']); ?></td>
                            <td><?php echo number_format($service['tarif'], 0, ',', ' '); ?> FCFA</td>
                            <td>
                                <a href="manage_services.php?action=edit&id=<?php echo $service['id']; ?>" class="btn-small">Modifier</a>
                                <a href="<?php echo BASE_URL; ?>admin/manage_services.php?action=delete&id=<?php echo $service['id']; ?>" onclick="return confirm('Etes-vous sur de vouloir supprimer ce service ?');" class="btn-small btn-cancel">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>