<?php echo view('common/head', ['titre' => 'Base de donnée']); ?>

<body>
    <h1>Visualisation et modification de la base de données</h1>

    <!-- Affichage des utilisateurs -->
    <h2>Utilisateurs</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['usr_id'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['is_active'] ? 'Oui' : 'Non' ?></td>
                    <td>
                        <a href="/database/edit/users/<?= $user['usr_id'] ?>">Modifier</a> | 
                        <a href="/database/delete/users/<?= $user['usr_id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Affichage des projets -->
    <h2>Projets</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= $project['prj_id'] ?></td>
					<td><?= $project['usr_id'] ?></td>
                    <td><?= $project['title'] ?></td>
					<td><?= $project['description'] ?></td>
					<td><?= $project['prj_created_at'] ?></td>
					<td><?= $project['prj_updated_at'] ?></td>
                    <td>
                        <a href="/database/edit/project/<?= $project['prj_id'] ?>">Modifier</a> | 
                        <a href="/database/delete/project/<?= $project['prj_id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

	<!-- Affichage des priorités -->
	<h2>Priorités</h2>
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Couleur</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($priorities as $priority): ?>
				<tr>
					<td><?= $priority['prio_id'] ?></td>
					<td><?= $priority['usr_id'] ?></td>
					<td><?= $priority['ordre'] ?></td>
					<td><?= $priority['name'] ?></td>
					<td style="background-color: <?= $priority['color'] ?>; color: white;"><?= $priority['color'] ?></td>
					<td>
						<a href="/database/edit/priority/<?= $priority['prio_id'] ?>">Modifier</a> | 
						<a href="/database/delete/priority/<?= $priority['prio_id'] ?>">Supprimer</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Affichage des tâches -->
	<h2>Tâches</h2>
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Titre</th>
				<th>Description</th>
				<th>Projet</th>
				<th>Priorité</th>
				<th>Statut</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($tasks as $task): ?>
				<tr>
					<td><?= $task['tsk_id'] ?></td>
					<td><?= $task['usr_id'] ?></td>
					<td><?= $task['prj_id'] ?></td>
					<td><?= $task['prio_id'] ?></td>
					<td><?= $task['title'] ?></td>
					<td><?= $task['description'] ?></td>
					<td><?= $task['due_date'] ?></td>
					<td><?= $task['status'] ?></td>
					<td><?= $task['tsk_created_at'] ?></td>
					<td><?= $task['tsk_updated_at'] ?></td>
					<td>
						<a href="/database/edit/task/<?= $task['tsk_id'] ?>">Modifier</a> | 
						<a href="/database/delete/task/<?= $task['tsk_id'] ?>">Supprimer</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Affichage des commentaires -->
	<h2>Commentaires</h2>
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Contenu</th>
				<th>Tâche</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($comments as $comment): ?>
				<tr>
					<td><?= $comment['cmt_id'] ?></td>
					<td><?= $comment['tsk_id'] ?></td>
					<td><?= $comment['usr_id'] ?></td>
					<td><?= $comment['content'] ?></td>
					<td><?= $comment['cmt_created_at'] ?></td>
					<td><?= $comment['cmt_updated_at'] ?></td>
					<td>
						<a href="/database/edit/comment/<?= $comment['cmt_id'] ?>">Modifier</a> | 
						<a href="/database/delete/comment/<?= $comment['cmt_id'] ?>">Supprimer</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Affichage des notifications -->
	<h2>Notifications</h2>
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Contenu</th>
				<th>Utilisateur</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($notifications as $notification): ?>
				<tr>
					<td><?= $notification['notif_id'] ?></td>
					<td><?= $notification['usr_id'] ?></td>
					<td><?= $notification['type'] ?></td>
					<td><?= $notification['status'] ?></td>
					<td><?= $notification['notif_created_at'] ?></td>

					<td>
						<a href="/database/edit/notification/<?= $notification['notif_id'] ?>">Modifier</a> | 
						<a href="/database/delete/notification/<?= $notification['notif_id'] ?>">Supprimer</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<p><a href="/">Retour à l'accueil</a></p>

<?php echo view('common/foot'); ?>

