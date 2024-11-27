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

	<div class="modal fade" id="AjoutTache" tabindex="-1" aria-labelledby="ajouttache" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ajouttache">Création d'une nouvelle tâche</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/ajouterTacheProjet" method="post">

                                <?php echo form_label('Nom de la tâche:', 'nomTache'); ?>
                                <?php echo form_input('nomTache', '', ['class' => 'form-control']); ?>

                                <?php echo form_label('Description de la tâche:', 'descriptionTache'); ?>
                                <?php echo form_textarea('descriptionTache', '', ['class' => 'form-control']); ?>

                                <?php 
                                    echo form_label('Choisissez votre priorité :', 'menuSelection', ['class' => 'form-label']); 

                                    // Préparation des options pour le dropdown
                                    $options = [];
                                    foreach ($priorities as $priority) {
                                        $options[$priority['prio_id']] = $priority['name'];
                                    }

                                    var_dump($options);

                                    // Génération du dropdown
                                    echo form_dropdown('menuSelection', $options, '', [
                                        'id' => 'menuSelection', 
                                        'class' => 'form-select'
                                    ]); 
                                ?>

                                <?php echo form_label('Date de fin de la tâche:', 'dateTache'); ?>
                                <?php echo form_input(['type' => 'date', 'name' => 'datetache', 'class' => 'form-control']); ?>
                        </div>
                        <div class="modal-footer">
                            <?php echo form_submit('submit', 'Créer la tâche', ['class' => 'btn btn-primary']); ?>
                            <?php echo form_close(); ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                        </div>
                    </div>
                </div>
            </div>
    <div class="row mt-4">
        <!-- Colonne À faire -->
        <div class="col-md-4">
            <div class="column-header text-center bg-warning text-white p-2 rounded mb-3">
                <h3>À faire</h3>
            </div>
            <div class="task-list">
                <?php if (!empty($tachesParStatut['a_faire'])): ?>
                    <?php foreach ($tachesParStatut['a_faire'] as $tache): ?>
                        <div class="card mb-3 shadow">
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
            <div class="column-header text-center bg-info text-white p-2 rounded mb-3">
                <h3>En cours</h3>
            </div>
            <div class="task-list">
                <?php if (!empty($tachesParStatut['en_cours'])): ?>
                    <?php foreach ($tachesParStatut['en_cours'] as $tache): ?>
                        <div class="card mb-3 shadow">
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
            <div class="column-header text-center bg-success text-white p-2 rounded mb-3">
                <h3>Terminé</h3>
            </div>
            <div class="task-list">
                <?php if (!empty($tachesParStatut['termine'])): ?>
                    <?php foreach ($tachesParStatut['termine'] as $tache): ?>
                        <div class="card mb-3 shadow">
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

<style>
	/* Style des en-têtes de colonnes */
.column-header {
    font-size: 1.5rem;
    font-weight: bold;
}

/* Liste des tâches */
.task-list {
    max-height: 70vh; /* Limite la hauteur pour éviter un trop grand contenu */
    overflow-y: auto; /* Barre de défilement si nécessaire */
}

/* Style des cartes */
.card {
    border: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Texte pour les cartes */
.card-title {
    font-weight: bold;
    color: #333;
}

.card-text {
    font-size: 0.9rem;
    color: #666;
}

/* Apparence responsive */
@media (max-width: 768px) {
    .task-list {
        max-height: none;
    }
}

</style>

<?php

echo view('common/foot');

?>