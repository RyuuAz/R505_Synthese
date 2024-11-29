<?php 
echo view('common/head', [
    'titre' => 'Tâches'
]);
?>
<button type="button" onclick="window.location.href='task/delayTaskFilter'">En retard</button>
<?php 

echo view('DefaultTaskView',[
    'tachesParStatut' => $taches
]);


?> 