<?php

// Responsabilité : accès aux données de la table film (SQL/PDO)
// Pas de HTML, pas de logique HTTP

// Rechercher dans la BDD la liste des films
function findAllFilms(PDO $pdo): array
{
    $sql = "SELECT id, titre, realisateur FROM films ORDER BY titre";

    $requete = $pdo->query($sql);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// Insérer dans la BDD un nouveau film