<?php echo view('common/head', ['titre' => 'Modifier ' . ucfirst($table)]); ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Modifier l'élément dans <?= ucfirst($table) ?></h1>

    <form action="/database/update/<?= $table ?>/<?= $item[$primary_key] ?>" method="post" class="w-50 mx-auto">
        <?php foreach ($item as $key => $value): ?>
            <?php if ($key !== $primary_key): ?> <!-- Ignorer la clé primaire -->
                <div class="mb-3">
                    <label for="<?= $key ?>" class="form-label"><?= ucfirst(str_replace('_', ' ', $key)) ?>:</label>
                    <input type="text" name="<?= $key ?>" id="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" class="form-control">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="/database" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php echo view('common/foot'); ?>
