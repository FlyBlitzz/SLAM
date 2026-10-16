<?php

// ------------------------------------------------------------
// Contrôleur permettant de traiter toutes les actions liées à la gestion des films
// ------------------------------------------------------------

// Responsabilité : coordonner le traitement d'une requête lié à la notion de film

// Accès au modèle
require_once __DIR__ . "/../model/repository/filmRepository.php";
// Accès à la fonction de rendu de vues (render)
require_once __DIR__ . "/../view/view.php";

// Traitement de l'action "action=list"
function listFilms(PDO $pdo): void
{
    // invoquer le modèle pour récupérer la liste des films
    $films = findAllFilms($pdo);

    // invoquer la vue pour afficher les données
    // require_once __DIR__ . "/../../views/films/index.php";

    render("films/index", [
        "title" => "Liste des films",
        'films' => $films,
    ]);
}

// Traitement de l'action "action=create"
function createFilm(PDO $pdo): void
{
    $errors = [];
    $titre = '';
    $realisateur = '';

    // Soumission du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Récupération des valeurs saisies
        $titre = trim($_POST['titre']);
        $realisateur = trim($_POST['realisateur']);

        // Validation des données
        if ($titre === '') {
            $errors[] = "Le titre est obligatoire";
        }
        if ($realisateur === '') {
            $errors[] = "Le réalisateur est obligatoire";
        }

        var_dump($errors);

        // Insertion en base de données si validation OK
        if ($errors === []) {
            // appel au modèle pour insérer les données
            insertFilm($pdo, $titre, $realisateur);
            // redirection vers la liste des films
            header('Location: index.php?action=list');
            exit();
        }

    }

    // Afficher le formulaire (VUE)
    // require_once __DIR__ . "/../../views/films/create.php";

    render("films/create", [
        "title" => "Ajouter un film",
        "errors" => $errors,
        "titre" => $titre,
        "realisateur" => $realisateur,
    ]);
}

function deleteFilm(PDO $pdo): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Supprimer la donnée
        $id = (int) $_POST['id'];
        deleteFilmById($pdo, $id);
        // 2. Rediriger l'utilisateur vers la liste
        header('Location: index.php?action=list');
        exit;
    }
}