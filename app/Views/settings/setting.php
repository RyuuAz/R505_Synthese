<?php
    echo view('common/head', [
        'titre' => 'Dashboard'
    ]);
    echo view("settings/onglet.php", [
        'priorities' => $priorities
    ]); ?>
    <?php echo view('common/foot');
?>