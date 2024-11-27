<?php

namespace App\Views\Dashboard\Component;

class TaskCase {
    static function genererBandeauTache($titre, $date, $description, $bgColor, $commentaires = []) {
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

        // Couleur éclaircie pour la partie dépliable
        $lightenedColor = self::lightenColor($bgColor, 30); // Éclaircir de 30%

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
                    <button class="icon-btn me-3"><i class="bi bi-trash"></i></button>
                    <!-- Bouton de dépliement -->
                    <button class="icon-btn" data-bs-toggle="collapse" data-bs-target="#task-details-' . md5($titre) . '" aria-expanded="false">
                        <i class="bi bi-chevron-right rotate-icon"></i>
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
                        ' . $commentairesHTML . '
                    </div>
                </div>
            </div>
        </div>
        ';
    }

    /**
     * Éclaircit une couleur HEX d'un certain pourcentage.
     * @param string $hex Couleur au format HEX (#RRGGBB)
     * @param int $percent Pourcentage d'éclaircissement (0-100)
     * @return string Couleur HEX éclaircie
     */
    static function lightenColor($hex, $percent) {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Calculer les nouvelles valeurs RGB
        $r = min(255, $r + ($r * $percent / 100));
        $g = min(255, $g + ($g * $percent / 100));
        $b = min(255, $b + ($b * $percent / 100));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}