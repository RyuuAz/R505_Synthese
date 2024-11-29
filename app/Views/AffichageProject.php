<?php 
$titre = "Projets";
include 'common/head.php'; 
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<div class="container mt-4">
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#AjoutProjet">
        Ajouter un projet
    </button>

    <!-- Modal d'ajout de projet -->
    <div class="modal fade" id="AjoutProjet" tabindex="-1" aria-labelledby="ajoutProjetLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajoutProjetLabel">Création d'un nouveau projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="dashboard/addproject" method="post">
                        <div class="mb-3">
                            <?php echo form_label('Nom du projet:', 'nomProjet'); ?>
                            <?php echo form_input('nomProjet', '', ['class' => 'form-control']); ?>
                        </div>
                        <div class="mb-3">
                            <?php echo form_label('Description du projet:', 'descriptionProjet'); ?>
                            <?php echo form_textarea('descriptionProjet', '', ['class' => 'form-control']); ?>
                        </div>
                        <div class="modal-footer">
                            <?php echo form_submit('submit', 'Créer le projet', ['class' => 'btn btn-primary']); ?>
                            <?php echo form_close(); ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Affichage des projets -->

    <?php if (isset($projects) && !empty($projects)): ?>
        <div class="row mt-4">
            <?php foreach ($projects as $project): ?>
                <div class="col-md-4 mb-3">
                    <a href="<?= site_url('projects/view/' . $project['prj_id']) ?>" 
                       class="card text-decoration-none" style="color: inherit;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($project['description']) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Aucun projet en cours.</p>
    <?php endif; ?>
</div>
