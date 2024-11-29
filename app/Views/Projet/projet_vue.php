
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">



<?php

echo view('common/head', [
    'titre' => 'Projet'
]);
?>
<header class="project-header">
        <h1><?= htmlspecialchars($projet['title']) ?></h1>
        <p class="project-description"><?= htmlspecialchars($projet['description']) ?></p>
    </header>

<?php
echo view('DefaultTaskView',[
    'taches' => $tachesParStatut,
]);
?>




