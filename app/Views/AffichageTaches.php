<?php 
echo view('common/head', [
    'titre' => 'Tâches'
]);

echo view('DefaultTaskView',[
    'tachesParStatut' => $taches,
]);


?> 