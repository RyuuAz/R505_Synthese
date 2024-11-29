<?php if (empty($tasks)): ?>
    <p>Pas de tâches en retard</p>
<?php else: ?>
    <div class="task-container">
        <?php foreach ($tasks as $task): ?>
            <div class="task-card" id="task-<?= $task['tsk_id']; ?>" data-task-id="<?= $task['tsk_id']; ?>">
                <h4 class="task-title"><?= htmlspecialchars($task["title"]); ?></h4>
                <p class="task-desc"><?= htmlspecialchars($task["description"]); ?></p>
                <span class="task-date">Échéance : <?= htmlspecialchars($task["due_date"]); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
