<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titre ?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" >
        <link rel="stylesheet" href="/assets/css/global.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <nav class="d-flex justify-content-between align-items-center p-3 bg bg-primary">
            <!-- Titre à gauche -->
            <a href="/dashboard"> <h1 class="m-0 text-light"><?php echo $titre ?></h1> </a>

            <!-- Icônes à droite, dans des div séparés -->
            <div class="d-flex gap-5">
                
                <div>
                    <a href="/users" class="text-light"><i class="bi bi-person-circle fs-1"></i></a>
                </div>
                <div>
                    <a href="/settings" class="text-light"><i class="bi bi-gear-fill fs-1"></i></a>
                </div>
                <div>
                    <a href="/logout" class="hover-danger text-light"><i class="bi bi-door-closed fs-1 hover-text-danger"></i></a>
                </div>
            </div>
        </nav>