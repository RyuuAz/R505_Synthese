
<div class="container mt-4">
    <!-- Barre principale -->
    <div class="task-bar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <strong class="me-3"> <?php $title ?> </strong>
            <span> <?php $due_date ?> </span>
        </div>
        <div class="d-flex align-items-center">
            <!-- Icônes d\'édition et de suppression -->
            <button class="icon-btn me-3"><i class="bi bi-pencil"></i></button>
            <button class="icon-btn me-3"><i class="bi bi-trash"></i></button>
            <!-- Bouton de dépliement -->
            <button class="icon-btn" data-bs-toggle="collapse" data-bs-target="#task-details" aria-expanded="false">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Contenu dépliable -->
    <div id="task-details" class="collapse mt-2">
        <div class="task-details">
            <ul class="mb-0">
                ' . <?php $commentaires ?>. '
            </ul>
        </div>
    </div>
</div> 
