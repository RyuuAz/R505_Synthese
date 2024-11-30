<?php 
$titre = "Projets";
echo view('common/head', [
    'titre' => $titre
]); 
?>

<div class="modern-container">
<header class="projects-header">
        <h1>Mes Projets</h1>
        <button class="add-btn" onclick="openPopup()">+ Ajouter un Projet</button>
    </header>

    <!-- Popup pour l'ajout de projet -->
    <div id="popup-add-project" class="popup-overlay" style="display: none;">
        <div class="popup-content">
            <h2>Ajouter un Projet</h2>
            <form id="add-project-form" action="/dashboard/addproject" method="POST">
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" required>

                <label for="description">Description :</label>
                <textarea id="description" name="description" required></textarea>

                <div class="popup-buttons">
                    <button type="submit" class="submit-btn">Ajouter</button>
                    <button type="button" class="cancel-btn" onclick="closePopup()">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Affichage des projets -->
    <?php if (isset($projects) && !empty($projects)): ?>
        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <a href="<?= site_url('projects/view/' . $project['prj_id']) ?>" class="project-card">
                    <div class="project-content">
                        <h5 class="project-title"><?= htmlspecialchars($project['title']) ?></h5>
                        <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="empty-projects-message">Aucun projet en cours pour le moment.</p>
    <?php endif; ?>
</div>

<script>
    // Ouvre la popup
function openPopup() {
    document.getElementById("popup-add-project").style.display = "flex";
}

// Ferme la popup
function closePopup() {
    document.getElementById("popup-add-project").style.display = "none";
}

</script>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">



    