<?php
function genererBandeauTache($titre, $date, $description, $commentaires = []) {
    // Convertir les commentaires en HTML si le tableau n'est pas vide
    $commentairesHTML = '';
    if (!empty($commentaires)) {
        foreach ($commentaires as $commentaire) {
            $commentairesHTML .= '
            <div class="d-flex justify-content-between align-items-center mb-2">
                <p class="mb-0 text-dark">' . htmlspecialchars($commentaire) . '</p>
                <div class="d-flex">
                    <!-- Icône de crayon pour l\'édition avec bouton stylisé -->
                    <button class="btn btn-sm btn-outline-primary me-2">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <!-- Icône de poubelle pour la suppression avec bouton stylisé -->
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>';
        }
    } else {
        $commentairesHTML = '<p>Aucun commentaire.</p>';
    }

    // Générer le bandeau HTML
    return '
    <div class="container mt-0 p-0">
        <!-- Barre principale -->
        <div class="task-bar d-flex align-items-center justify-content-between bg-orange p-3">
            <div class="d-flex align-items-center">
                <!-- Affichage du titre et de la date d\'échéance -->
                <strong class="me-3">' . htmlspecialchars($titre) . '</strong>
                <span>' . htmlspecialchars($date) . '</span>
            </div>
            <div class="d-flex align-items-center">
                <!-- Icônes d\'édition et de suppression -->
                <button class="icon-btn me-3"><i class="bi bi-pencil"></i></button>
                <button class="icon-btn me-3"><i class="bi bi-trash"></i></button>
                <!-- Bouton de dépliement -->
                <button class="icon-btn" data-bs-toggle="collapse" data-bs-target="#task-details-' . md5($titre) . '" aria-expanded="false">
                    <i class="bi bi-chevron-right rotate-icon"></i>
                </button>
            </div>
        </div>

        <!-- Contenu dépliable -->
        <div id="task-details-' . md5($titre) . '" class="collapse mt-0 p-0">
            <div class="task-details bg-orange p-3">
                <!-- Description -->
                <div class="task-description">
                    <strong>Description :</strong>
                    <p>' . htmlspecialchars($description) . '</p>
                </div>

                <!-- Séparation entre la description et les commentaires -->
                <hr class="my-3" />

                <!-- Commentaires -->
                <div class="task-comments">
                    <strong>Commentaires :</strong>
                    ' . $commentairesHTML . '
                </div>
            </div>
        </div>
    </div>
    ';
}
?>