<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <div class="brand">
            <div>
                <h1>Gestion des films</h1>
                <p class="subtitle"><strong>Architecture MVC :</strong> découpage en composants MVC
                </p>
            </div>
        </div>

        <!-- Navigation entre les pages -->
        <nav class="nav-bar">
            <a href="index.php?action=list" class="active">📜 Liste des films</a>
            <a href="index.php?action=create">➕ Ajouter un film</a>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

</body>

</html>