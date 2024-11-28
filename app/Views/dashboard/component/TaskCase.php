<?php
namespace App\Views\Dashboard\Component;


class TaskCase {
    static function genererBandeauTache($tsk_id,$titre, $date, $description, $bgColor, $commentaires = []) {
        // Convertir les commentaires en HTML si le tableau n'est pas vide
        $commentairesHTML = '';
        if (!empty($commentaires)) {
            foreach ($commentaires as $commentaire) {
                $commentairesHTML .= '
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <p class="mb-0 text-dark">' . htmlspecialchars($commentaire['content']) . '</p>
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
            $commentairesHTML .= '<p>Aucun commentaire.</p>';
        }

        // Générer les éléments du formulaire
        $hidden = form_hidden('tsk_id', $tsk_id);
        $textarea = form_textarea('content', 'Contenu du commentaire', ['class' => 'form-control']);
        $submit = form_submit('submit', 'Mettre un commentaire', ['class' => 'btn btn-primary']);

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
                <div class="task-details" style="background-color: ' . htmlspecialchars($bgColor) . '"; padding: 1rem;">
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

                        <div class="container-fluid">
                            <!-- Ligne qui occupe toute la largeur -->
                            <div class="d-flex justify-content-end pt-3">
                                <!-- Bouton avec icône "+" aligné à droite -->
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#AjoutCommentaire">
                                    <i class="bi bi-plus-square fs-1"></i> <!-- Icône "+" -->
                                </button>
                            </div>
                        </div>

                        <div class="modal fade" id="AjoutCommentaire" tabindex="-1" aria-labelledby="ajoutcommentaire" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ajoutcommentaire">Création d\'un nouveau commentaire</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div> 
                                <div class="modal-body">
                                    <form action="comments/store" method="post"> 
                                    ' . $hidden . '
                                    ' . $textarea . ' 
                                    </div>
                                <div class="modal-footer"> 
                                '. $submit . '
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                        ' . $commentairesHTML . '
                    </div>
                </div>
            </div>
        </div>
        ';
    }
}