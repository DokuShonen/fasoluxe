<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/admin_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Gestion des Clients</h2>

        <!-- Formulaire de modification -->
        <?php if ($is_editing): ?>
            <div class="form-container">
                <h3>Modifier le client</h3>
                <form action="manage_clients.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $client_to_edit['id']; ?>">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" value="<?php echo $client_to_edit['nom'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom</label>
                            <input type="text" name="prenom" value="<?php echo $client_to_edit['prenom'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="<?php echo $client_to_edit['email'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="tel" name="telephone" value="<?php echo $client_to_edit['telephone'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="classification">Classification</label>
                            <select name="classification" required>
                                <option value="Occasionnel" <?php echo (isset($client_to_edit['classification']) && $client_to_edit['classification'] == 'Occasionnel') ? 'selected' : ''; ?>>Occasionnel</option>
                                <option value="Regulier" <?php echo (isset($client_to_edit['classification']) && $client_to_edit['classification'] == 'Regulier') ? 'selected' : ''; ?>>Regulier</option>
                                <option value="VIP" <?php echo (isset($client_to_edit['classification']) && $client_to_edit['classification'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="carte_fidelite">Carte de Fidelite</label>
                            <input type="checkbox" name="carte_fidelite" value="1" <?php echo (isset($client_to_edit['carte_fidelite']) && $client_to_edit['carte_fidelite'] == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label for="reduction">Reduction (%)</label>
                            <input type="number" name="reduction" step="0.01" min="0" max="100" value="<?php echo $client_to_edit['reduction'] ?? 0; ?>">
                        </div>
                    </div>
                    <button type="submit" name="action" value="update" class="btn">Mettre a jour le client</button>
                    <a href="manage_clients.php" class="btn btn-cancel">Annuler l'edition</a>
                </form>
            </div>
        <?php endif; ?>

        <!-- Liste des clients -->
        <h3>Liste des Clients Existants</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Nom</th><th>Prenom</th><th>Email</th><th>Telephone</th><th>Classification</th><th>Fidelite</th><th>Reduction</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($client['nom']); ?></td>
                            <td><?php echo htmlspecialchars($client['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($client['email']); ?></td>
                            <td><?php echo htmlspecialchars($client['telephone']); ?></td>
                            <td><?php echo htmlspecialchars($client['classification']); ?></td>
                            <td><?php echo ($client['carte_fidelite'] == 1) ? 'Oui' : 'Non'; ?></td>
                            <td><?php echo htmlspecialchars($client['reduction']); ?>%</td>
                            <td>
                                <a href="manage_clients.php?action=edit&id=<?php echo $client['id']; ?>" class="btn-small">Modifier</a>
                                <a href="<?php echo BASE_URL; ?>admin/manage_clients.php?action=delete&id=<?php echo $client['id']; ?>" onclick="return confirm('Etes-vous sur de vouloir supprimer ce client ?');" class="btn-small btn-cancel">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>