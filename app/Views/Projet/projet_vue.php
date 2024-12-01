<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">



<?php

echo view('common/head', [
    'titre' => 'Projet'
]);
?>
<header class="project-header">
    <h1><?= htmlspecialchars($projet['title']) ?></h1>
    <p class="project-description"><?= htmlspecialchars($projet['description']) ?></p>
</header>

<!-- Bouton pour ouvrir la pop-up -->
<div class="projects-header">
    <button type="button" class="add-btn" onclick="openTaskModal()">Créer une tâche</button>
</div>

<!-- Pop-up pour ajouter une tâche -->
<div id="add-task-modal" class="popup-overlay" style="display:none;">
    <div class="popup-content">
        <h3>Ajouter une tâche</h3>
        <form id="add-task-form" method="POST" action="/task/store">
        <?= csrf_field() ?>
            <div class="form-group">
                <label for="task-title">Titre</label>
                <input type="text" id="task-title" name="title" required>
            </div>
            <div class="form-group">
                <label for="task-desc">Description</label>
                <textarea id="task-desc" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="task-date">Date d'échéance</label>
                <input type="date" id="task-date" name="due_date" required>
            </div>

            <input hidden name="prj_id" value="<?= $projet['prj_id'] ?>" required>
            
            <div class="form-group">
                <label for="task-priority">Priorité</label>
                <select id="task-priority" name="prio_id" required>
                    <?php foreach ($priorities as $priority): ?>
                        <option value="<?= $priority['prio_id'] ?>"><?= $priority['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="popup-buttons">
                <button type="submit" class="submit-btn">Ajouter</button>
                <button type="button" class="cancel-btn" onclick="closeTaskModal()">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openTaskModal() {
        document.getElementById("add-task-modal").style.display = "flex";
        document.body.style.overflow = "hidden"; // Empêche le scroll en arrière-plan
    }

    function closeTaskModal() {
        document.getElementById("add-task-modal").style.display = "none";
        document.body.style.overflow = "auto"; // Restaure le scroll
    }
</script>


<?php
echo view('DefaultTaskView', [
    'taches' => $tachesParStatut,
]);
?>