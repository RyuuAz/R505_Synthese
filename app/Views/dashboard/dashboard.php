<?php
    echo view('common/head', [
        'titre' => 'Dashboard'
    ]);
    echo view("dashboard/onglet.php", [
        'tasks' => $tasks
    ]); ?>
    <?php echo view('common/foot');
?>