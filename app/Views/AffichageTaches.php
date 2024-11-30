<?php
echo view('common/head', [
    'titre' => 'Tâches'
]);
?>
<div class="button-group">
    <button type="button" class="add-btn " data-filter="all" onclick="loadTasks('all')">Toutes les
        tâches</button>
    <button type="button" class="add-btn" data-filter="delayed" onclick="loadTasks('delayed')">En retard</button>
    <button type="button" class="add-btn" data-filter="priority" onclick="loadTasks('priority')">Priorités</button>
    <button type="button" class="add-btn" data-filter="dueDate" onclick="loadTasks('dueDate')">Échéance</button>
</div>

<button type="button" class="add-btn" onclick=openTaskModal()>Créer une tâches</button>

<!-- Popup pour ajouter une tâche -->
<div id="add-task-modal" class="popup-overlay" style="display:none;">
    <div class="popup-content">
        <h3>Ajouter une tâche</h3>
        <form id="add-task-form" method="POST" action="/task/store">
            <div class="form-group">
                <label for="task-title">Titre</label>
                <input type="text" id="task-title" name="title" required>
            </div>
            <div class="form-group">
                <label for="task-desc">Description</label>
                <textarea id="task-desc" name="description" ></textarea>
            </div>
            <div class="form-group">
                <label for="task-date">Date d'échéance</label>
                <input type="date" id="task-date" name="due_date" required>
            </div>
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
    </div>
    </form>
</div>
</div>

<div id="tasksContainer">
    <?php
    // Afficher les tâches par défaut (Toutes les tâches)
    echo view('DefaultTaskView', [
        'tachesParStatut' => $taches
    ]);
    ?>
</div>

<script>
    function loadTasks(filterType) {
        const tasksContainer = document.getElementById('tasksContainer');

        // Affiche un message de chargement
        tasksContainer.innerHTML = '<p>Chargement des tâches...</p>';

        // Définir l'URL en fonction du type de filtre
        let url = '';
        switch (filterType) {
            case 'delayed':
                url = 'tasks/delay-tasks';
                break;
            case 'priority':
                url = 'tasks/priority-tasks';
                break;
            case 'dueDate':
                url = 'tasks/due-date-tasks';
                break;
            default:
                url = 'tasks/all-tasks';
        }

        // Requête fetch pour charger les tâches
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.text(); // Récupère le HTML généré par la vue
            })
            .then(data => {
                tasksContainer.innerHTML = data; // Insère le contenu dans la page
            })
            .catch(error => {
                console.error('Erreur :', error);
                tasksContainer.innerHTML = '<p>Une erreur s\'est produite lors du chargement des tâches.</p>';
            });
    }

    function openTaskModal() {
        document.getElementById("add-task-modal").style.display = "flex";
        document.body.style.overflow = "hidden"; // Empêche le scroll en arrière-plan
    }

    function closeTaskModal() {
        document.getElementById("add-task-modal").style.display = "none";
        document.body.style.overflow = "auto"; // Restaure le scroll
    }

</script>