

<?php 
$titre = "Accueil";
include 'common/head.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - <?php echo $titre ?></title>
    <style>
        /* Styles pour la page d'accueil */
        .main-content {
            text-align: center;
            padding: 50px 20px;
        }

        .main-content h1 {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }

        .categories {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }

        .category-card {
            background: white;
            padding: 30px;
            width: 250px;
            height: 250px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .category-card i {
            font-size: 40px;
            color: #1E88E5;
            margin-bottom: 15px;
        }

        .category-card h3 {
            font-size: 20px;
            color: #333;
        }

        .category-card a {
            display: inline-block;
            margin-top: 10px;
            color: #ff8670;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .category-card a:hover {
            color: #4fc3f7;
        }
    </style>
</head>
<body>
    <!-- Section principale -->
    <section class="main-content">
        <h1>Bienvenue sur votre gestionnaire de tâches</h1>
        <div class="categories">
            <!-- Tâche unique -->
            <a href="/tasks" class="text-decoration-none"><div class="category-card">
                <i class="bi bi-check-circle"></i>
                <h3>Tâche unique</h3>
            </div></a>

            <!-- Projets -->
            <a href="/projects" class="text-decoration-none"><div class="category-card">
                <i class="bi bi-folder"></i>
                <h3>Projets</h3>
            </div></a>

            <!-- Toutes les tâches -->
            <a href="/tasks" class="text-decoration-none"><div class="category-card">
                <i class="bi bi-list-task"></i>
                <h3>Toutes les tâches</h3>
                
            </div>
        </div>
    </section>
</body>
</html>
