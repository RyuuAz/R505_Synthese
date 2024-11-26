<div class="container-fluid p-0">
    <!-- Navigation des onglets -->
    <ul class="nav nav-tabs d-flex w-100" id="myTab" role="tablist">
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link active w-100" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks"
                type="button" role="tab" aria-controls="tasks" aria-selected="true">
                Tâches individuelles
            </button>
        </li>
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link w-100" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects"
                type="button" role="tab" aria-controls="projects" aria-selected="false">
                Projets
            </button>
        </li>
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link w-100" id="isolated-tasks-tab" data-bs-toggle="tab" data-bs-target="#isolated-tasks"
                type="button" role="tab" aria-controls="isolated-tasks" aria-selected="false">
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
                            <form action="dashboard/addtask" method="post">

                                <?php echo form_label('Nom de la tâche:', 'nomTache'); ?>
                                <?php echo form_input('nomTache', '', ['class' => 'form-control']); ?>

                                <?php echo form_label('Date de fin de la tâche:', 'dateTache'); ?>
                                <?php echo form_input(['type' => 'date', 'name' => 'datetache', 'class' => 'form-control']); ?>

                                <?php echo form_label('Description de la tâche:', 'descriptionTache'); ?>
                                <?php echo form_textarea('descriptionTache', '', ['class' => 'form-control']); ?>

                                <label for="menuSelection" class="form-label">Choisissez une option :</label>
                                <select name="menuSelection" id="menuSelection" class="form-select">
                                </select>
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
            include 'component/case.php';

            foreach ($tasks as $task) {
                echo view('dashboard/component/case', [
                    'titre' => $task['title'],
                    'date' => $task['due_date'],
                    'description' => $task['description'],
                    'commentaires' => $task['comments']
                ]);
            }
            ?>
        </div>
        </div>
        <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="projects-tab">
            <p>Liste des projets en cours.</p>
            <?php if (isset($projects) && !empty($projects)) : ?>
                <ul class="list-group">
                <?php foreach ($projects as $project) : ?>
                <li class="list-group item">
                    <h5><?php echo $project['title']; ?></h5>
                    <p><?php echo $project['description']; ?></p>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else : ?>
                <p>Aucun projet en cours.</p>
            <?php endif; ?>

            <br>

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


        </div>
        <div class="tab-pane fade" id="isolated-tasks" role="tabpanel" aria-labelledby="isolated-tasks-tab">
            <p>Tâches isolées à accomplir.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>