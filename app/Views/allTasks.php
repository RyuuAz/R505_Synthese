
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>


	<?php
		echo view('common/head', [
			'titre' => 'Toutes les tâches'
		]);
		?>

		<?php if (session()->getFlashdata('error')): ?>
			<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
		<?php endif; ?>

		<?php if (session()->getFlashdata('success')): ?>
			<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
		<?php endif; ?>

		<div class="task-list">
		<?php
			if (isset($tasks) && !empty($tasks)) :
                    // Organiser les commentaires par tâche pour un accès rapide
                    $commentairesParTache = [];
                    foreach ($commentaires as $commentaire) {
                        $tsk_id = $commentaire['tsk_id'];
                        if (!isset($commentairesParTache[$tsk_id])) {
                            $commentairesParTache[$tsk_id] = [];
                        }
                        $commentairesParTache[$tsk_id][] = $commentaire;
                    }

                    // Parcourir les tâches
                    foreach ($tasks as $task):
                        // Trouver la priorité associée
                        $priorityColor = '';
                        foreach ($priorities as $priority) {
                            if ($priority['prio_id'] === $task['prio_id']) {
                                $priorityColor = $priority['color'];
                                break;
                            }
                        }

                        // Récupérer les commentaires associés à la tâche
                        $commentairesTrie = $commentairesParTache[$task['tsk_id']] ?? [];

                        // Générer le bandeau pour la tâche
                        echo \App\Controllers\TaskController::genererBandeauTache(
                            $task['tsk_id'],
                            $task['title'],
                            $task['due_date'],
                            $task['description'],
                            $priorityColor,
                            $commentairesTrie
                        );
                    endforeach;
                else: ?>
                    <p>Aucune tâche pour ce projet.</p>
                <?php endif; ?>
		</div>

	<?php
	echo "<script src='/assets/js/comments.js'></script>";
	echo view('common/foot');
?>
