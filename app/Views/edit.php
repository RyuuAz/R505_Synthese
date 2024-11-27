<form method="post" action="/task/update/<?= $task['tsk_id'] ?>">
    <label for="title">Titre</label>
    <input 
        type="text" 
        id="title" 
        name="title" 
        value="<?= $task['title'] ?>" 
        placeholder="Titre" 
        required 
    />

    <label for="description">Description</label>
    <textarea 
        id="description" 
        name="description" 
        placeholder="Description"><?= $task['description'] ?></textarea>

    <label for="due_date">Échéance</label>
    <input 
        type="date" 
        id="due_date" 
        name="due_date" 
        value="<?= $task['due_date'] ?>" 
    />

    <button type="submit">Modifier</button>
</form>
<a href="/dashboard">Retour au tableau de bord</a>
