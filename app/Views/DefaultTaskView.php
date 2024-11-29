<div class="modern-container">

    <main>
        <section class="tasks-section">
            <div class="task-column" id="todo" ondragover="allowDrop(event)" ondrop="drop(event, 'pending')">
                <h3 class="column-title todo-title">À Faire</h3>
                <div class="task-list">
                    <?php if (!empty($tachesParStatut['a_faire'])): ?>
                        <?php foreach ($tachesParStatut['a_faire'] as $tache): ?>
                            <div class="task-card" id="task-<?= $tache['tsk_id']; ?>" draggable="true" ondragstart="drag(event)"
                                data-task-id="<?= $tache['tsk_id']; ?>"
                                data-task-status="<?= htmlspecialchars($tache['status']); ?>">
                                <h4 class="task-title"><?= htmlspecialchars($tache["title"]); ?></h4>
                                <p class="task-desc"><?= htmlspecialchars($tache["description"]); ?></p>
                                <p class="task-date">Échéance : <?= htmlspecialchars($tache["due_date"]); ?></p>
                                <div class="task-actions">
                                    <button class="edit-btn" onclick="openModalEditTask(this.closest('.task-card'))" title="Modifier">
                                        ✏️
                                    </button>
                                    <button class="delete-btn" onclick="deleteTask(<?= $tache['tsk_id']; ?>)" title="Supprimer">
                                        🗑️
                                    </button>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-column">Pas de tâches.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="task-column" id="in_progress" ondragover="allowDrop(event)" ondrop="drop(event, 'overdue')">
                <h3 class="column-title in-progress-title">En Cours</h3>
                <div class="task-list">
                    <?php if (!empty($tachesParStatut['en_cours'])): ?>
                        <?php foreach ($tachesParStatut['en_cours'] as $tache): ?>
                            <div class="task-card" id="task-<?= $tache['tsk_id']; ?>" draggable="true" ondragstart="drag(event)"
                                data-task-id="<?= $tache['tsk_id']; ?>"
                                data-task-status="<?= htmlspecialchars($tache['status']); ?>">
                                <h4 class="task-title"><?= htmlspecialchars($tache["title"]); ?></h4>
                                <p class="task-desc"><?= htmlspecialchars($tache["description"]); ?></p>
                                <p class="task-date">Échéance : <?= htmlspecialchars($tache["due_date"]); ?></p>
                                <div class="task-actions">
                                    <button class="edit-btn" onclick="openModalEditTask(this.closest('.task-card'))" title="Modifier">
                                        ✏️
                                    </button>
                                    <button class="delete-btn" onclick="deleteTask(<?= $tache['tsk_id']; ?>)" title="Supprimer">
                                        🗑️
                                    </button>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-column">Pas de tâches.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="task-column" id="done" ondragover="allowDrop(event)" ondrop="drop(event, 'completed')">
                <h3 class="column-title done-title">Terminé</h3>
                <div class="task-list">
                    <?php if (!empty($tachesParStatut['termine'])): ?>
                        <?php foreach ($tachesParStatut['termine'] as $tache): ?>
                            <div class="task-card" id="task-<?= $tache['tsk_id']; ?>" draggable="true" ondragstart="drag(event)"
                                data-task-id="<?= $tache['tsk_id']; ?>"
                                data-task-status="<?= htmlspecialchars($tache['status']); ?>">
                                <h4 class="task-title"><?= htmlspecialchars($tache["title"]); ?></h4>
                                <p class="task-desc"><?= htmlspecialchars($tache["description"]); ?></p>
                                <p class="task-date">Échéance : <?= htmlspecialchars($tache["due_date"]); ?></p>
                                <div class="task-actions">
                                    <button class="edit-btn" onclick="openModalEditTask(this.closest('.task-card'))" title="Modifier">
                                        ✏️
                                    </button>
                                    <button class="delete-btn" onclick="deleteTask(<?= $tache['tsk_id']; ?>)" title="Supprimer">
                                        🗑️
                                    </button>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-column">Pas de tâches.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Modal des commentaires -->
        <div id="comments-modal" class="popup-overlay" style="display:none;">

            <div class="popup-content">

                <?php
                    $model = new \App\Models\CommentModel();
                    $comments = $model->getCommentsByTask($task['tsk_id']);
                    if(isset($tasks))
                        foreach ($tasks as $task) {
                            echo \App\Controllers\TaskController::genererBandeauTache($task['tsk_id'], $task['title'], $task['due_date'], $task['description'], $task['bgColor'], $comments);
                        }
                ?>

            </div>


        <!-- Modal de modification de tâche -->
        <div id="edit-modal" class="popup-overlay" style="display:none;">

            <div class="popup-content">

                <h5 class=>Modifier la tâche</h5>

                <form id="edit-task-form" method="POST" action="/task/update">
                    <input type="hidden" name="tsk_id" id="modal-task-id">
                    <div class="mb-3">
                        <input type="text" name="title" id="modal-task-title" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="description" id="modal-task-desc" required></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="date" name="due_date" id="modal-task-date" required>
                    </div>
                    <div class="popup-buttons"><button type="submit" class="submit-btn">Enregistrer</button>
                        <button type="" button class="cancel-btn" onclick="closeModal()">Fermer</button>
                    </div>
                </form>

            </div>

        </div>


    </main>
</div>

<style>
    /* Conteneur principal */
    .modern-container {
        font-family: 'Inter', sans-serif;
        padding: 20px;
        background-color: #f5f7fa;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* En-tête */
    .project-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .project-header h1 {
        font-size: 2.5rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .project-description {
        font-size: 1.2rem;
        color: #7f8c8d;
    }

    /* Section des colonnes */
    .tasks-section {
        display: flex;
        gap: 20px;
        width: 100%;
        max-width: 1200px;
    }

    /* Colonnes */
    .task-column {
        flex: 1;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        height: 75vh;
        width: 300vh;
        overflow-y: auto;
    }

    .column-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .todo-title {
        color: #f39c12;
    }

    .in-progress-title {
        color: #3498db;
    }

    .done-title {
        color: #2ecc71;
    }

    /* Liste des tâches */
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Carte tâche */
    .task-card {
        background-color: #ecf0f1;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        cursor: grab;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .task-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .task-desc {
        font-size: 1rem;
        color: #7f8c8d;
        margin: 10px 0;
    }

    .task-date {
        font-size: 0.9rem;
        color: #95a5a6;
        text-align: right;
    }

    /* Texte colonne vide */
    .empty-column {
        text-align: center;
        color: #bdc3c7;
        font-size: 1rem;
    }
</style>



<script>
    // Permet le dépôt
    function allowDrop(event) {
        event.preventDefault();
    }

    // Capture l'événement de début de glissement
    function drag(event) {
        event.dataTransfer.setData("taskId", event.target.id);
    }

    // Gère le dépôt
    function drop(event, newStatus) {
        event.preventDefault();
        const taskId = event.dataTransfer.getData("taskId");
        const taskElement = document.getElementById(taskId);

        // Trouve la zone cible (toujours la div "task-list")
        const taskColumn = event.target.closest(".task-column").id;
        const col = document.getElementById(taskColumn);

        console.log(taskColumn);
        if (taskColumn) {

            col.querySelector(".task-list").appendChild(taskElement); // Ajoute la tâche à la fin de la liste
        } else {
            console.error("Impossible de trouver une liste de tâches cible.");
        }

        // Mise à jour du statut via AJAX
        fetch('/updateTaskStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
            },
            body: JSON.stringify({ id: taskId.replace("task-", ""), status: newStatus })
        })
            .then(response => response.json())
            .then(data => console.log('Statut mis à jour:', data))
            .catch(error => console.error('Erreur:', error));
    }

    function openModalEditTask(task) {
        document.getElementById("modal-task-id").value = task.dataset.taskId;
        document.getElementById("modal-task-title").value = task.querySelector(".task-title").innerText;
        document.getElementById("modal-task-desc").value = task.querySelector(".task-desc").innerText;
        document.getElementById("modal-task-date").value = task.querySelector(".task-date").innerText.split(" : ")[1];
        document.getElementById("edit-modal").style.display = "flex";
        document.body.style.overflow = "hidden"; // Empêche le scroll en arrière-plan
    }

    function closeModal() {
        document.getElementById("edit-modal").style.display = "none";
        document.body.style.overflow = "auto"; // Restaure le scroll
    }

    // Fonction pour supprimer une tâche
    function deleteTask(taskId) {
        if (confirm("Voulez-vous vraiment supprimer cette tâche ?")) {
            fetch(`/task/delete/${taskId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
                },
                body: JSON.stringify({ id: taskId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`task-${taskId}`).remove(); // Retire la tâche de l'interface
                        alert("Tâche supprimée avec succès !");
                    } else {
                        alert("Erreur lors de la suppression de la tâche.");
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }
    }


    // Fonction pour supprimer une tâche
    function deleteTask(taskId) {
        if (confirm("Voulez-vous vraiment supprimer cette tâche ?")) {
            fetch(`/task/delete/${taskId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
                },
                body: JSON.stringify({ id: taskId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`task-${taskId}`).remove(); // Retire la tâche de l'interface
                        alert("Tâche supprimée avec succès !");
                    } else {
                        alert("Erreur lors de la suppression de la tâche.");
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }
    }


    function openCommentsModal(task) {
        document.getElementById("comments-modal").style.display = "flex";
        document.body.style.overflow = "hidden"; // Empêche le scroll en arrière-plan
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".task-card").forEach(card => {
            card.addEventListener("dblclick", () => openModal(card));
        });
    });

</script>