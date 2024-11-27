<?php echo view('common/head', ['titre' => 'Base de donnée']); ?>

    <h1>Modifier l'élément dans <?= ucfirst($table) ?></h1>

    <form action="/database/update/<?= $table ?>/<?= $item[$primary_key] ?>" method="post">
        <?php foreach ($item as $key => $value): ?>
            <?php if ($key !== $primary_key): ?> <!-- Ignorer la clé primaire -->
                <label for="<?= $key ?>"><?= ucfirst(str_replace('_', ' ', $key)) ?>:</label>
                <input type="text" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>"><br>
            <?php endif; ?>
        <?php endforeach; ?>

        <button type="submit">Mettre à jour</button>
    </form>

<?php echo view('common/foot'); ?>
