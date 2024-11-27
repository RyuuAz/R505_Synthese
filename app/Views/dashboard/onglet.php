<?php $activeTab = session()->getFlashdata('active_tab') ?? 'tasks'; ?>

<div class="container-fluid p-0">
    <!-- Navigation des onglets -->
    <ul class="nav nav-tabs d-flex w-100" id="myTab" role="tablist">
    <li class="nav-item flex-fill text-center" role="presentation">
        <button class="nav-link w-100 <?= $activeTab === 'tasks' ? 'active' : '' ?>" id="tasks-tab"
            data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab"
            aria-controls="tasks" aria-selected="<?= $activeTab === 'tasks' ? 'true' : 'false' ?>">
            Tâches individuelles
        </button>
    </li>
    <li class="nav-item flex-fill text-center" role="presentation">
        <button class="nav-link w-100 <?= $activeTab === 'projects' ? 'active' : '' ?>" id="projects-tab"
            data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab"
            aria-controls="projects" aria-selected="<?= $activeTab === 'projects' ? 'true' : 'false' ?>">
            Projets
        </button>
    </li>
    <li class="nav-item flex-fill text-center" role="presentation">
        <button class="nav-link w-100 <?= $activeTab === 'isolated_tasks' ? 'active' : '' ?>" id="isolated-tasks-tab"
            data-bs-toggle="tab" data-bs-target="#isolated-tasks" type="button" role="tab"
            aria-controls="isolated-tasks" aria-selected="<?= $activeTab === 'isolated_tasks' ? 'true' : 'false' ?>">
            Toutes les Tâches
        </button>
    </li>
</ul>

    <!-- Contenu des onglets -->
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">

            <div class="container-fluid">
                <!-- Ligne qui occupe toute la largeur -->
                <div class="d-flex justify-content-end pt-3">
                    <!-- Bouton avec icône "+" aligné à droite -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AjoutTache">
                        <i class="bi bi-plus fs-3"></i> <!-- Icône "+" -->
                    </button>
                </div>
            </div>

            <div class="modal fade" id="AjoutTache" tabindex="-1" aria-labelledby="ajouttache" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ajouttache">Création d'une nouvelle tâche</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="dashboard/addLoneTask" method="post">

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
            
            <?php
                if ((isset($tasks) && !empty($tasks))) : ?>
                    <?php foreach ($tasks as $task): ?>
                        <?php echo \App\Views\dashboard\component\TaskCase::genererBandeauTache($task['tsk_id']
                        ,$task["title"],$task['due_date'],$task['description']) ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune tâche pour ce projet.</p>
                <?php endif; ?>
        </div>
    </div>

    
    <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="projects-tab">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AjoutProjet">
            Ajouter un projet
        </button>

        <div class="modal fade" id="AjoutProjet" tabindex="-1" aria-labelledby="ajoutprojet" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ajoutprojet">Création d'un nouveau projet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="dashboard/addproject" method="post">

                            <?php echo form_label('Nom du projet:', 'nomProjet'); ?>
                            <?php echo form_input('nomProjet', '', ['class' => 'form-control']); ?>

                            <?php echo form_label('Description du projet:', 'descriptionProjet'); ?>
                            <?php echo form_textarea('descriptionProjet', '', ['class' => 'form-control']); ?>
                    </div>
                    <div class="modal-footer">
                        <?php echo form_submit('submit', 'Créer le projet', ['class' => 'btn btn-primary']); ?>
                        <?php echo form_close(); ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                    </div>
                </div>
            </div>
        </div>
    
    <?php if (isset($projects) && !empty($projects)): ?>
        <div class="container mt-4">
            <div class="d-flex flex-wrap justify-content-left">
                <?php foreach ($projects as $project): ?>
                    <a href="<?= site_url('projects/view/' . $project['prj_id']) ?>" 
                       class="card m-2 text-decoration-none" 
                       style="width: 18rem; height: 150px; color: inherit;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars($project['description']) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <p>Aucun projet en cours.</p>
    <?php endif; ?>
</div>



        


    </div>
    <div class="modal fade" id="AjoutTache" tabindex="-1" aria-labelledby="ajouttache" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajouttache">Ajout d'une nouvelle tâche</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="dashboard/addLoneTask" method="post">

                        <!-- Titre -->
                        <?php echo form_label('Titre de la tâche :', 'title'); ?>
                        <?php echo form_input('title', '', ['class' => 'form-control', 'required' => 'required']); ?>

                        <!-- Description -->
                        <?php echo form_label('Description :', 'description'); ?>
                        <?php echo form_textarea('description', '', ['class' => 'form-control']); ?>

                        <!-- Date d'échéance -->
                        <?php echo form_label('Date d\'échéance :', 'due_date'); ?>
                        <?php echo form_input('due_date', '', ['class' => 'form-control', 'type' => 'date', 'required' => 'required']); ?>


                </div>
                <div class="modal-footer">
                    <!-- Bouton pour soumettre -->
                    <?php echo form_submit('submit', 'Créer la tâche', ['class' => 'btn btn-primary']); ?>
                    <?php echo form_close(); ?>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
.card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: scale(1.02); /* Léger agrandissement */
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}
.card {
    visibility: visible !important; /* Assure que les cartes restent visibles */
    opacity: 1 !important;          /* Assure une opacité complète */
}

</style>