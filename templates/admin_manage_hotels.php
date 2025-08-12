<div class="dashboard-container">
    <?php include __DIR__ . '/../src/includes/admin_sidebar.php'; ?>

    <main class="dashboard-content">
        <h2>Gestion des Hotels</h2>

        <!-- Formulaire d'ajout/modification -->
        <div class="form-container">
            <h3><?php echo $is_editing ? 'Modifier l\'hotel' : 'Ajouter un nouvel hotel'; ?></h3>
            <form action="manage_hotels.php" method="POST">
                <?php if ($is_editing): ?>
                    <input type="hidden" name="id" value="<?php echo $hotel_to_edit['id']; ?>">
                <?php endif; ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom">Nom de l'hotel</label>
                        <input type="text" name="nom" value="<?php echo $hotel_to_edit['nom'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" value="<?php echo $hotel_to_edit['ville'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie">Categorie (etoiles)</label>
                        <input type="number" name="categorie" min="1" max="5" value="<?php echo $hotel_to_edit['categorie'] ?? 3; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?php echo $hotel_to_edit['email'] ?? ''; ?>">
                    </div>
                    <div class="form-group full-width">
                        <label for="adresse">Adresse</label>
                        <textarea name="adresse" rows="2"><?php echo $hotel_to_edit['adresse'] ?? ''; ?></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea name="description" rows="3"><?php echo $hotel_to_edit['description'] ?? ''; ?></textarea>
                    </div>
                     <div class="form-group full-width">
                        <label for="site_web">Site Web</label>
                        <input type="text" name="site_web" value="<?php echo $hotel_to_edit['site_web'] ?? ''; ?>">
                    </div>
                </div>
                <button type="submit" name="action" value="<?php echo $is_editing ? 'update' : 'create'; ?>" class="btn">
                    <?php echo $is_editing ? 'Mettre a jour' : 'Ajouter l\'hotel'; ?>
                </button>
                <?php if ($is_editing): ?>
                    <a href="manage_hotels.php" class="btn btn-cancel">Annuler l'edition</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Liste des hotels -->
        <h3>Liste des Hotels Existants</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Nom</th><th>Ville</th><th>Categorie</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($hotels as $hotel): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($hotel['nom']); ?></td>
                            <td><?php echo htmlspecialchars($hotel['ville']); ?></td>
                            <td><?php echo str_repeat('&#9733;', $hotel['categorie']); ?></td>
                            <td>
                                <a href="manage_hotels.php?action=edit&id=<?php echo $hotel['id']; ?>" class="btn-small">Modifier</a>
                                <a href="<?php echo BASE_URL; ?>admin/manage_hotels.php?action=delete&id=<?php echo $hotel['id']; ?>" onclick="return confirm('Etes-vous sur de vouloir supprimer cet hotel ?');" class="btn-small btn-cancel">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>