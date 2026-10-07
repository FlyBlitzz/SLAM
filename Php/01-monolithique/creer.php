<?php

// ------------------------------------------------------------
// APPLICATION MONOLITHIQUE AMÉLIORÉE (SANS MVC)
// Page : Création d'un film
// ------------------------------------------------------------
// Cette page gère à la fois l'affichage du formulaire et
// le traitement de la soumission POST.
// Elle réutilise la connexion PDO via db.php et redirige
// vers index.php (liste) après insertion réussie (pattern PRG).
// ------------------------------------------------------------

// 1. Inclusion de la connexion à la base de données
require_once __DIR__ . '/db.php';

$errors = [];
$titre = '';
$realisateur = '';

// 2. Traitement de la soumission du formulaire
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $realisateur = trim($_POST['realisateur'] ?? '');

    // Validation des données
    if ($titre === '') {
        $errors[] = 'Le titre est obligatoire.';
    }

    if ($realisateur === '') {
        $errors[] = 'Le réalisateur est obligatoire.';
    }

    // Si aucune erreur, enregistrement en base de données
    if ($errors === []) {
        $sql = '
            INSERT INTO films (titre, realisateur)
            VALUES (:titre, :realisateur)
        ';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'titre' => $titre,
            'realisateur' => $realisateur,
        ]);

        // Redirection vers la liste des films (Post-Redirect-Get)
        header('Location: index.php?created=1');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films - Ajouter un film (Monolithe amélioré)</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <div class="brand">
            <div>
                <h1>Gestion des films</h1>
                <p class="subtitle"><strong>Architecture monolithique améliorée :</strong> découpage en pages sans MVC</p>
            </div>
        </div>

        <!-- Navigation entre les pages -->
        <nav class="nav-bar">
            <a href="index.php">📜 Liste des films</a>
            <a href="creer.php" class="active">➕ Ajouter un film</a>
        </nav>
    </header>

    <main>
        <h2>Ajouter un nouveau film</h2>

        <?php if ($errors !== []): ?>
            <div class="alert alert-error">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="creer.php" class="card-form">
            <div class="form-group">
                <label for="titre">Titre du film</label>
                <input
                    type="text"
                    id="titre"
                    name="titre"
                    value="<?= htmlspecialchars($titre) ?>"
                    placeholder="Ex : Inception"
                    required>
            </div>

            <div class="form-group">
                <label for="realisateur">Réalisateur</label>
                <input
                    type="text"
                    id="realisateur"
                    name="realisateur"
                    value="<?= htmlspecialchars($realisateur) ?>"
                    placeholder="Ex : Christopher Nolan"
                    required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer le film</button>
                <a href="index.php" class="btn btn-outline">Annuler / Retour à la liste</a>
            </div>
        </form>
    </main>

</body>

</html>
