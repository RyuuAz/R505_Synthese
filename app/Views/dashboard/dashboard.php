<?php
    echo view('common/head', [
        'titre' => 'Dashboard'
    ]);
?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>


<?php    
    echo view("dashboard/onglet.php", [
        'tasks' => $tasks,
        'commentaires' => $commentaires,
        'projects' => $projects,
        'priorities' => $priorities
    ]); ?>
    <?php echo view('common/foot');
?>