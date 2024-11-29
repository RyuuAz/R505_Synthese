<?php 
echo view('common/head', [
    'titre' => 'Tâches'
]);
?>
<div class="button-group">
    <button type="button" class="filter-button active" data-filter="all" onclick="loadTasks('all')">Toutes les tâches</button>
    <button type="button" class="filter-button" data-filter="delayed" onclick="loadTasks('delayed')">En retard</button>
    <button type="button" class="filter-button" data-filter="priority" onclick="loadTasks('priority')">Priorités</button>
    <button type="button" class="filter-button" data-filter="dueDate" onclick="loadTasks('dueDate')">Échéance</button>
</div>

<div id="tasksContainer">
    <?php 
    // Afficher les tâches par statut
    echo view('DefaultTaskView', [
        'tachesParStatut' => $taches,   // Tâches classées par statut
    ]);
    ?>
</div>


<script>
    function loadTasks(filterType) {
        const tasksContainer = document.getElementById('tasksContainer');
        
        // Affiche un message de chargement
        tasksContainer.innerHTML = '<p>Chargement des tâches...</p>';
        
        // Définir l'URL en fonction du type de filtre
        let url = '';
        switch (filterType) {
            case 'delayed':
                url = 'tasks/delay-tasks';
                break;
            case 'priority':
                url = 'tasks/priority-tasks';
                break;
            case 'dueDate':
                url = 'tasks/due-date-tasks';
                break;
            default:
                url = 'tasks/all-tasks';
        }
        
        // Requête fetch pour charger les tâches
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.text(); // Récupère le HTML généré par la vue
            })
            .then(data => {
                tasksContainer.innerHTML = data; // Insère le contenu dans la page
            })
            .catch(error => {
                console.error('Erreur :', error);
                tasksContainer.innerHTML = '<p>Une erreur s\'est produite lors du chargement des tâches.</p>';
            });
    }
</script>