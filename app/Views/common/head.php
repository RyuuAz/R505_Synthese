<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titre ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" >
    <link rel="stylesheet" href="/assets/css/global.css">
    <style>
        /* Styles pour le header */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f5f7;
        }

        .header {
            background: linear-gradient(135deg, #ff70a1, #ff8670);
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 80px;
        }

        .header .title {
            font-size: 24px;
            font-weight: bold;
        }

        .header .nav-links {
            display: flex;
            gap: 20px;
        }

        .header .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .header .nav-links a:hover {
            color: #ffeb3b;
        }
    </style>
   
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="title">Service De Gestion de Tache</div>
        <nav class="nav-links">
            <a href="/dashboard">Accueil</a>
            <a href="/projects">Projets</a>
            <a href="/tasks">Tâches</a>
            <a href="/users">Utilisateurs</a>
            <a href="/logout">Déconnexion</a>
        </nav>
    </header>
</body>
</html>
