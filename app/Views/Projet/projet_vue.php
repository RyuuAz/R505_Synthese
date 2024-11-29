<?php

echo view('common/head', [
    'titre' => 'Projet'
]);
?>


<div class="container mt-4">
    <h1 class="text-center mb-4"><?= htmlspecialchars($projet['title']) ?></h1>
    <p class="text-center text-muted"><?= htmlspecialchars($projet['description']) ?></p>

    <h2 class="text-center mt-5">Tâches</h2>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AjoutTache">
        Ajouter une tâche
    </button>

    <!-- Modal d'ajout de tâche (inchangé) -->
    <div class="modal fade" id="AjoutTache" tabindex="-1" aria-labelledby="ajouttache" aria-hidden="true">
        <!-- Votre contenu de modal ici -->
    </div>

    <div class="row mt-4">
        <!-- Colonne À faire -->
        <div class="col-md-4">
            <div class="column-header text-center bg-warning text-white p-2 rounded">
                <h3>À faire</h3>
            </div>
            <div class="task-list" id="todo" ondragover="allowDrop(event)" ondrop="drop(event, 'pending')">
                <?php if (!empty($tachesParStatut['a_faire'])): ?>
                    <?php foreach ($tachesParStatut['a_faire'] as $tache): ?>
                        <div class="card mb-3 shadow" id="task-<?= $tache['tsk_id']; ?>" draggable="true"
                            ondragstart="drag(event)" data-task-id="<?= $tache['tsk_id']; ?>" data-task-status="a_faire">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($tache["title"]); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($tache["description"]); ?></p>
                                <p class="card-text text-end">
                                    <small class="text-muted">Échéance : <?= htmlspecialchars($tache["due_date"]); ?></small>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Aucune tâche à faire.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Colonne En cours -->
        <div class="col-md-4">
            <div class="column-header text-center bg-info text-white p-2 rounded">
                <h3>En cours</h3>
            </div>
            <div class="task-list" id="in_progress" ondragover="allowDrop(event)" ondrop="drop(event, 'overdue')">
                <?php if (!empty($tachesParStatut['en_cours'])): ?>
                    <?php foreach ($tachesParStatut['en_cours'] as $tache): ?>
                        <div class="card mb-3 shadow" id="task-<?= $tache['tsk_id']; ?>" draggable="true"
                            ondragstart="drag(event)" data-task-id="<?= $tache['tsk_id']; ?>" data-task-status="en_cours">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($tache["title"]); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($tache["description"]); ?></p>
                                <p class="card-text text-end">
                                    <small class="text-muted">Échéance : <?= htmlspecialchars($tache["due_date"]); ?></small>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Aucune tâche en cours.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Colonne Terminé -->
        <div class="col-md-4">
            <div class="column-header text-center bg-success text-white p-2 rounded">
                <h3>Terminé</h3>
            </div>
            <div class="task-list" id="done" ondragover="allowDrop(event)" ondrop="drop(event, 'completed')">
                <?php if (!empty($tachesParStatut['termine'])): ?>
                    <?php foreach ($tachesParStatut['termine'] as $tache): ?>
                        <div class="card mb-3 shadow" id="task-<?= $tache['tsk_id']; ?>" draggable="true"
                            ondragstart="drag(event)" data-task-id="<?= $tache['tsk_id']; ?>" data-task-status="termine">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($tache["title"]); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($tache["description"]); ?></p>
                                <p class="card-text text-end">
                                    <small class="text-muted">Échéance : <?= htmlspecialchars($tache["due_date"]); ?></small>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Aucune tâche terminée.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

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
        const taskList = event.target.closest(".task-list");
        if (taskList) {
            taskList.appendChild(taskElement); // Ajoute la tâche à la fin de la liste
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
</script>


<style>
    /* Conteneur des colonnes */
    .task-list {
        background-color: #f8f9fa; /* Couleur d'arrière-plan claire */
        border: 1px solid #dee2e6; /* Bordure fine */
        border-radius: 8px; /* Coins arrondis */
        padding: 10px;
        min-height: 60vh; /* Assure une hauteur minimale */
        overflow-y: auto; /* Barre de défilement si contenu dépasse */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Légère ombre */
    }

    /* Colonnes */
    .col-md-4 {
        padding: 15px; /* Ajoute de l'espace autour */
    }

    /* En-têtes de colonnes */
    .column-header {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Tâches (cartes) */
    .card {
        margin-bottom: 10px;
        border: 1px solid #ddd; /* Bordure fine */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Effet visuel */
    }

    /* Amélioration du texte */
    .card-title {
        font-weight: bold;
        color: #333;
    }

    .card-text {
        font-size: 0.9rem;
        color: #555;
    }

    /* Apparence mobile */
    @media (max-width: 768px) {
        .task-list {
            min-height: 40vh; /* Réduit la hauteur minimale */
        }
    }
</style>
