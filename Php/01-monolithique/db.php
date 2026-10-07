<?php

// ------------------------------------------------------------
// CONNEXION À LA BASE DE DONNÉES SQLITE
// ------------------------------------------------------------
// Amélioration par rapport au monolithe brut :
// La connexion PDO et l'initialisation de la base de données
// sont centralisées dans ce fichier pour être réutilisées
// par toutes les pages (sans duplication de code).
// ------------------------------------------------------------

$dbPath = __DIR__ . '/cinema.sqlite';
$isNewDatabase = !file_exists($dbPath) || filesize($dbPath) === 0;

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// Initialisation de la structure et des données à partir de database-sqlite.sql si nouveau fichier
if ($isNewDatabase) {
    $sqlFile = __DIR__ . '/database-sqlite.sql';
    if (file_exists($sqlFile)) {
        $pdo->exec(file_get_contents($sqlFile));
    }
}
