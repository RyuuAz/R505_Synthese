<div class="modern-container">
    <header class="projects-header">
        <h1>Gestion des Priorités</h1>
        <button class="add-btn" onclick="openPopup()">+ Ajouter une Priorité</button>
    </header>

    <!-- Popup pour l'ajout de priorité -->
    <div id="popup-add-priority" class="popup-overlay" style="display: none;">
        <div class="popup-content">
            <h2>Ajouter une Priorité</h2>
            <form id="add-priority-form" action="/settings/create-priority" method="POST">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>

                <label for="color">Couleur :</label>
                <input type="color" id="color" name="color" required>

                <label for="ordre">Ordre :</label>
                <select id="ordre" name="ordre" required>
                    <option value="">-- Sélectionnez un ordre --</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <div class="popup-buttons">
                    <button type="submit" class="submit-btn">Ajouter</button>
                    <button type="button" class="cancel-btn" onclick="closePopup()">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Affichage des priorités -->
    <?php if (!empty($priorities)): ?>
        <div class="projects-grid">
            <?php foreach ($priorities as $priority): ?>
                <div class="project-card priority-card d-flex justify-content-between align-items-center" style="border-left: 4px solid <?= htmlspecialchars($priority['color']) ?>">
                    <div>
                        <h5 class="project-title mb-0"><?= htmlspecialchars($priority['name']) ?> (Ordre : <?= htmlspecialchars($priority['ordre']) ?>)</h5>
                    </div>
                    <div>
                        <button class="btn btn-warning btn-sm me-2" onclick="openEditPopup(<?= $priority['prio_id'] ?>)">Modifier</button>
                        <a href="<?= site_url('settings/delete-priority/' . $priority['prio_id']) ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </div>
                </div>

                <!-- Popup pour modifier une priorité -->
                <div id="popup-edit-priority-<?= $priority['prio_id'] ?>" class="popup-overlay" style="display: none;">
                    <div class="popup-content">
                        <h2>Modifier la Priorité</h2>
                        <form action="/settings/update-priority/<?= $priority['prio_id'] ?>" method="POST">
                            <label for="name-<?= $priority['prio_id'] ?>">Nom :</label>
                            <input type="text" id="name-<?= $priority['prio_id'] ?>" name="name" value="<?= htmlspecialchars($priority['name']) ?>" required>

                            <label for="color-<?= $priority['prio_id'] ?>">Couleur :</label>
                            <input type="color" id="color-<?= $priority['prio_id'] ?>" name="color" value="<?= htmlspecialchars($priority['color']) ?>" required>

                            <label for="ordre-<?= $priority['prio_id'] ?>">Ordre :</label>
                            <select id="ordre-<?= $priority['prio_id'] ?>" name="ordre" required>
                                <option value="">-- Sélectionnez un ordre --</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($i == $priority['ordre']) ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>

                            <div class="popup-buttons">
                                <button type="submit" class="submit-btn">Modifier</button>
                                <button type="button" class="cancel-btn" onclick="closeEditPopup(<?= $priority['prio_id'] ?>)">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="empty-projects-message">Aucune priorité définie pour le moment.</p>
    <?php endif; ?>
</div>

<script>
    // Ouvre la popup d'ajout
    function openPopup() {
        document.getElementById("popup-add-priority").style.display = "flex";
    }

    // Ferme la popup d'ajout
    function closePopup() {
        document.getElementById("popup-add-priority").style.display = "none";
    }

    // Ouvre la popup de modification
    function openEditPopup(priorityId) {
        document.getElementById(`popup-edit-priority-${priorityId}`).style.display = "flex";
    }

    // Ferme la popup de modification
    function closeEditPopup(priorityId) {
        document.getElementById(`popup-edit-priority-${priorityId}`).style.display = "none";
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
