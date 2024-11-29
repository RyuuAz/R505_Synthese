<?php
namespace App\Views\Dashboard\Component;

class TaskCase {
    static function genererBandeauTache($tsk_id, $titre, $date, $description, $bgColor, $commentaires = []) {
        // Convertir les commentaires en HTML si le tableau n'est pas vide
        $commentairesHTML = '';
        if (!empty($commentaires)) {
            foreach ($commentaires as $commentaire) {
                $commentairesHTML .= '
                <div class="editable-parent d-flex justify-content-between align-items-center mb-2">
                    <div class="editable-comment" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                        <p class="mb-0 text-dark comment-text">' . htmlspecialchars($commentaire['content']) . '</p>
                        <input class="form-control comment-input d-none" type="text" value="' . htmlspecialchars($commentaire['content']) . '">
                    </div>
                    <div class="d-flex">
                        <!-- Bouton d\'édition -->
                        <button class="btn btn-sm btn-outline-primary me-2 edit-btn" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success me-2 validate-btn d-none" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                            <i class="bi bi-check-lg"></i>
                        </button>

                        <!-- Bouton de suppression -->
                        <button class="btn btn-sm btn-outline-danger">
                            <a class="danger" href="comments/delete/' . htmlspecialchars($commentaire['cmt_id']) . '">
                                <i class="bi bi-trash"></i>
                            </a>
                        </button>
                    </div>
                </div>';
            }
        } else {
            $commentairesHTML .= '<p>Aucun commentaire.</p>';
        }

        // Générer les éléments du formulaire
        $hidden = form_hidden('tsk_id', $tsk_id);
        $textarea = form_textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Écrire un commentaire...']);
        $submit = form_submit('submit', 'Ajouter un commentaire', ['class' => 'btn btn-primary mt-2']);

        // Générer le bandeau HTML
        return '
        <div class="container mt-0 p-0 mb-3">
            <!-- Barre principale -->
            <div class="task-bar d-flex align-items-center justify-content-between" style="background-color: ' . htmlspecialchars($bgColor) . '; padding: 1rem;">
                <div class="d-flex align-items-center">
                    <!-- Affichage du titre et de la date d\'échéance -->
                    <strong class="me-3">' . htmlspecialchars($titre) . '</strong>
                    <span>' . htmlspecialchars($date) . '</span>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Icônes d\'édition et de suppression -->
                    <button class="icon-btn me-3"><i class="bi bi-pencil"></i></button>
                    <a href="/dashboard/deleteLoneTask/' . $tsk_id . '" class="icon-btn me-3">
                        <i class="bi bi-trash"></i>
                    </a>
                    <!-- Bouton de dépliement -->
                    <button class="icon-btn" data-bs-toggle="collapse" data-bs-target="#task-details-' . md5($titre) . '" aria-expanded="false">
                        <i type="button" class="bi bi-chevron-right rotate-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Contenu dépliable -->
            <div id="task-details-' . md5($titre) . '" class="collapse mt-0 p-0">
                <div class="task-details" style="background-color: ' . htmlspecialchars($bgColor) . '; padding: 1rem;">
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
                        <hr class="my-3" />
                        <!-- Formulaire pour ajouter un commentaire -->
                        <form action="comments/store" method="post">
                            ' . $hidden . '
                            ' . $textarea . '
                            ' . $submit . '
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
}
