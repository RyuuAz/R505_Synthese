<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Priorités</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid p-0">
    <ul class="nav nav-tabs d-flex w-100" id="myTab" role="tablist">
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link active w-100" id="priorities-tab" data-bs-toggle="tab" data-bs-target="#priorities"
                type="button" role="tab" aria-controls="priorities" aria-selected="true">
                Priorités
            </button>
        </li>
    </ul>

    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="priorities" role="tabpanel" aria-labelledby="priorities-tab">

            <div class="container-fluid">
                <div class="d-flex justify-content-end pt-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPriorityModal">
                        <i class="bi bi-plus fs-3"></i> Ajouter une priorité
                    </button>
                </div>
            </div>

            <!-- Modal pour ajouter une priorité -->
            <div class="modal fade" id="addPriorityModal" tabindex="-1" aria-labelledby="addPriorityModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPriorityModalLabel">Ajouter une priorité</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?= form_open('settings/create-priority') ?>
                                <div class="mb-3">
                                    <?= form_label('Nom de la priorité', 'name', ['class' => 'form-label']) ?>
                                    <?= form_input('name', '', ['class' => 'form-control', 'required' => 'required']) ?>
                                </div>
                                <!-- Sélecteur de couleur pour la priorité -->
                                <div class="mb-3">
                                    <?= form_label('Choisissez la couleur de la priorité:', 'color', ['class' => 'form-label']) ?>
                                    <?= form_input(['type' => 'color', 'name' => 'color', 'class' => 'form-control', 'required' => 'required']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= form_label('Ordre (sélectionnez un chiffre)', 'ordre', ['class' => 'form-label']) ?>
                                    <select name="ordre" class="form-select" required>
                                        <option value="">-- Sélectionnez un ordre --</option>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <?= form_submit('submit', 'Créer', ['class' => 'btn btn-primary']) ?>
                            <?= form_close() ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="mt-4">Vos Priorités</h2>
            <ul class="list-group">
                <?php if (!empty($priorities)): ?>
                    <?php foreach ($priorities as $priority): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <span style="color: <?= esc($priority['color']) ?>;">■</span> 
                                <?= esc($priority['name']) ?> (Ordre : <?= esc($priority['ordre']) ?>)
                            </span>
                            <a href="<?= site_url('settings/delete-priority/' . $priority['prio_id']) ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">Aucune priorité définie.</li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
