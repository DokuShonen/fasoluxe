<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/admin_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Gestion des Chambres</h2>

        <!-- Formulaire d'ajout/modification -->
        <div class="form-container">
            <h3><?php echo $is_editing ? 'Modifier la chambre' : 'Ajouter une nouvelle chambre'; ?></h3>
            <form action="manage_chambres.php" method="POST">
                <?php if ($is_editing): ?>
                    <input type="hidden" name="id" value="<?php echo $chambre_to_edit['id']; ?>">
                <?php endif; ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="hotel_id">Hotel</label>
                        <select name="hotel_id" required>
                            <?php foreach ($hotels as $hotel): ?>
                                <option value="<?php echo $hotel['id']; ?>" <?php echo (isset($chambre_to_edit['hotel_id']) && $chambre_to_edit['hotel_id'] == $hotel['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($hotel['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type_chambre_id">Type de Chambre</label>
                        <select name="type_chambre_id" required>
                            <?php foreach ($types_chambre as $type): ?>
                                <option value="<?php echo $type['id']; ?>" <?php echo (isset($chambre_to_edit['type_chambre_id']) && $chambre_to_edit['type_chambre_id'] == $type['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($type['nom']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numero_chambre">Numero de Chambre</label>
                        <input type="text" name="numero_chambre" value="<?php echo $chambre_to_edit['numero_chambre'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tarif_nuit">Tarif par Nuit (FCFA)</label>
                        <input type="number" name="tarif_nuit" step="0.01" value="<?php echo $chambre_to_edit['tarif_nuit'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="equipements">Equipements (separes par des virgules)</label>
                        <input type="text" name="equipements" value="<?php echo $chambre_to_edit['equipements'] ?? ''; ?>">
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea name="description" rows="3"><?php echo $chambre_to_edit['description'] ?? ''; ?></textarea>
                    </div>
                </div>
                <button type="submit" name="action" value="<?php echo $is_editing ? 'update' : 'create'; ?>" class="btn">
                    <?php echo $is_editing ? 'Mettre a jour' : 'Ajouter la chambre'; ?>
                </button>
                <?php if ($is_editing): ?>
                    <a href="manage_chambres.php" class="btn btn-cancel">Annuler l'edition</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Liste des chambres -->
        <h3>Liste des Chambres Existantes</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Hotel</th><th>Numero</th><th>Type</th><th>Tarif</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($chambres as $chambre): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($chambre['hotel_nom']); ?></td>
                            <td><?php echo htmlspecialchars($chambre['numero_chambre']); ?></td>
                            <td><?php echo htmlspecialchars($chambre['type_nom']); ?></td>
                            <td><?php echo number_format($chambre['tarif_nuit'], 0, ',', ' '); ?> FCFA</td>
                            <td>
                                <a href="manage_chambres.php?action=edit&id=<?php echo $chambre['id']; ?>" class="btn-small">Modifier</a>
                                <a href="<?php echo BASE_URL; ?>admin/manage_chambres.php?action=delete&id=<?php echo $chambre['id']; ?>" onclick="return confirm('Etes-vous sur de vouloir supprimer cette chambre ?');" class="btn-small btn-cancel">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>