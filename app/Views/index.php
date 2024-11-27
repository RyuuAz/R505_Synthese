<h1>Dashboard</h1>
<a href="/task/create">Créer une tâche</a>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Échéance</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= $task['title'] ?></td>
            <td><?= $task['description'] ?></td>
            <td><?= $task['due_date'] ?></td>
            <td>
                <a href="/task/edit/<?= $task['tsk_id'] ?>">Modifier</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
