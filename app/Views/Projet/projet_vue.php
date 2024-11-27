<?php 

echo view('common/head', [
	'titre' => 'Projet'
]);
 ?>

<div class="container mt-4">
	<h1><?= htmlspecialchars($projet['title']) ?></h1>
	<p><?= htmlspecialchars($projet['description']) ?></p>
	

	

	<h2>Tâches</h2>

	<?php if ((isset($taches) && !empty($taches))) : ?>
	<?php foreach ($taches as $tache): ?>
		<?php echo \App\Views\dashboard\component\TaskCase::genererBandeauTache($tache["title"],$tache['due_date'],$tache['description']) ?>
	<?php endforeach; ?>
	<?php else: ?>
		<p>Aucune tâche pour ce projet.</p>
	<?php endif; ?>
</div>

<?php

echo view('common/foot');

?>

