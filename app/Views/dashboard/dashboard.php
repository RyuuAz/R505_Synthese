<?php
    echo view('common/head', [
        'titre' => 'Dashboard'
    ]);
    echo view("dashboard/onglet.php", [
        'tasks' => $tasks,
        'projects' => $projects,
        'priorities' => $priorities
    ]); ?>
    <?php echo view('common/foot');
?>