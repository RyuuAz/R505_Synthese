
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>


	<?php
		echo view('common/head', [
			'titre' => 'Toutes les tâches sans projet'
		]);
		?>

		<?php if (session()->getFlashdata('error')): ?>
			<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
		<?php endif; ?>

		<?php if (session()->getFlashdata('success')): ?>
			<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
		<?php endif; ?>
	<?php
	echo "<script src='/assets/js/comments.js'></script>";
	echo view('common/foot');
?>
