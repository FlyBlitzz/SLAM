<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="brand">
            <div>
                <p class="brand-title">Covoiturage entre enseignants</p>
                <p class="subtitle">Partageons nos trajets entre collègues.</p>
            </div>
        </div>

        <nav class="nav-bar" aria-label="Navigation principale">
            <a href="index.php?action=bienvenue" <?= $pageCourante === 'bienvenue' ? ' class="active" aria-current="page"' : '' ?>>Bienvenue</a>
            <?php if (!isset($_SESSION['utilisateur_id']) || !is_int($_SESSION['utilisateur_id'])): ?>
                <a href="index.php?action=inscription" <?= $pageCourante === 'inscription' ? ' class="active" aria-current="page"' : '' ?>>Créer un compte</a>
                <a href="index.php?action=connexion" <?= $pageCourante === 'connexion' ? ' class="active" aria-current="page"' : '' ?>>Se connecter</a>
            <?php else: ?>
                <a href="index.php?action=espace" <?= $pageCourante === 'espace' ? ' class="active" aria-current="page"' : '' ?>>Mon espace</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?= $contenu ?>
    </main>
</body>

</html>