<div class="container-fluid p-0">
    <!-- Navigation des onglets -->
    <ul class="nav nav-tabs d-flex w-100" id="myTab" role="tablist">
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link active w-100" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab" aria-controls="tasks" aria-selected="true">
                Tâches
            </button>
        </li>
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link w-100" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab" aria-controls="projects" aria-selected="false">
                Projets
            </button>
        </li>
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link w-100" id="isolated-tasks-tab" data-bs-toggle="tab" data-bs-target="#isolated-tasks" type="button" role="tab" aria-controls="isolated-tasks" aria-selected="false">
                Tâches isolées
            </button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
        
        </div>
        <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="projects-tab">
            <p>Liste des projets en cours.</p>
        </div>
        <div class="tab-pane fade" id="isolated-tasks" role="tabpanel" aria-labelledby="isolated-tasks-tab">
            <p>Tâches isolées à accomplir.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
