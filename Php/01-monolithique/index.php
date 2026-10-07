<?php

// ------------------------------------------------------------
// APPLICATION MONOLITHIQUE AMÉLIORÉE (SANS MVC)
// Page : Liste des films
// ------------------------------------------------------------
// Caractéristiques de cette étape :
// 1. Découpage par pages : chaque écran a sa propre page PHP
//    (ici la liste, dans creer.php le formulaire d'ajout).
// 2. Mutualisation de la connexion PDO dans db.php.
// 3. Toujours PAS de MVC : la page traite sa requête,
//    exécute sa requête SQL et génère son propre HTML.
// ------------------------------------------------------------

// 1. Inclusion de la connexion à la base de données
require_once __DIR__ . '/db.php';

// 2. Récupération des films
$sql = '
    SELECT id, titre, realisateur
    FROM films
    ORDER BY titre
';

$stmt = $pdo->query($sql);
$films = $stmt->fetchAll();

// 3. Message de confirmation éventuel après redirection
$success = isset($_GET['created']) && $_GET['created'] === '1';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films - Liste (Monolithe amélioré)</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <div class="brand">
            <div>
                <h1>Gestion des films</h1>
                <p class="subtitle"><strong>Architecture monolithique améliorée :</strong> découpage en pages sans MVC
                </p>
            </div>
        </div>

        <!-- Navigation entre les pages -->
        <nav class="nav-bar">
            <a href="index.php" class="active">📜 Liste des films</a>
            <a href="creer.php">➕ Ajouter un film</a>
        </nav>
    </header>

    <main>
        <?php if ($success): ?>
            <div class="alert alert-success">
                ✅ Le film a été enregistré avec succès !
            </div>
        <?php endif; ?>

        <div class="films-header">
            <h2>Films enregistrés (<?= count($films) ?>)</h2>
            <a href="creer.php" class="btn btn-primary">+ Ajouter un film</a>
        </div>

        <?php if ($films === []): ?>
            <div class="empty-state">
                <p>Aucun film enregistré pour le moment.</p>
                <a href="creer.php" class="btn btn-primary">Créer le premier film</a>
            </div>
        <?php else: ?>
            <div class="films-grid">
                <?php foreach ($films as $film): ?>
                    <article class="film-card">
                        <h3><?= htmlspecialchars($film['titre']) ?></h3>
                        <p><strong>Réalisateur :</strong> <?= htmlspecialchars($film['realisateur']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

</body>

</html>