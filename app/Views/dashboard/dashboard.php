<?php
    echo view('common/head');
    echo view("dashboard/onglet.php", [
        'tasks' => $tasks
    ]); ?>
    <div class="container-fluid">
        <!-- Ligne qui occupe toute la largeur -->
        <div class="d-flex justify-content-end pt-3">
            <!-- Bouton avec icône "+" aligné à droite -->
            <button class="btn btn-primary">
                <i class="bi bi-plus fs-3"></i> <!-- Icône "+" -->
            </button>
        </div>
    </div>
    <?php echo view('common/foot');
?>