<div class="container-fluid p-0">
    <!-- Navigation des onglets -->
    <ul class="nav nav-tabs d-flex w-100" id="myTab" role="tablist">
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link active w-100" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks"
                type="button" role="tab" aria-controls="tasks" aria-selected="true">
                Tâches
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
                Tâches isolées
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
                    <button class="btn btn-primary">
                    <i class="bi bi-plus fs-3"></i> <!-- Icône "+" -->
                </button>
            </div>
            <?php 
            include 'component/case.php';

            echo genererBandeauTache(
                'Tâche 1', 
                '12/12/2024', 
                'Description de la tâche 1', 
                ['Commentaire 1', 'Commentaire 2']);?>
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

                            <!-- Priorité -->
                            <?php echo form_label('Priorité :', 'prio_id'); ?>
                            <select name="prio_id" id="prio_id" class="form-control" required>
                                <option value="">-- Sélectionnez une priorité --</option>
                                <?php foreach ($priorities as $priority): ?>
                                    <option value="<?= esc($priority['prio_id']) ?>">
                                        <?= esc($priority['name']) ?> (<?= esc($priority['color']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>

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