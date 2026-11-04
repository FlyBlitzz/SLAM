<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/../Controller/bienvenueControleur.php';
require_once __DIR__ . '/../Controller/inscriptionControleur.php';
require_once __DIR__ . '/../Controller/connexionControleur.php';

function afficherErreur404(string $action = ''): void
{
    http_response_code(404);
    afficherVue('errors/404', [
        'titre' => '404 — Page introuvable',
        'pageCourante' => '',
        'action' => $action,
    ]);
}

function afficherErreur405(array $methodesAutorisees = [], string $methode = ''): void
{
    http_response_code(405);

    if ($methodesAutorisees !== []) {
        header('Allow: ' . implode(', ', $methodesAutorisees));
    }

    afficherVue('errors/405', [
        'titre' => '405 — Méthode non autorisée',
        'pageCourante' => '',
        'methodesAutorisees' => $methodesAutorisees,
        'methode' => $methode,
    ]);
}

function routerRequete(PDO $connexion): void
{
    // Le fichier retourne un tableau : le relire à chaque appel du routeur.
    $routes = require __DIR__ . '/../../config/routes.php';
    $action = $_GET['action'] ?? 'bienvenue';
    $methode = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    // Une action peut aussi être envoyée sous forme de tableau dans l'URL.
    if (!is_string($action) || !array_key_exists($action, $routes)) {
        afficherErreur404(is_string($action) ? $action : '');
        return;
    }

    if (!in_array($methode, $routes[$action], true)) {
        afficherErreur405($routes[$action], $methode);
        return;
    }

    $utilisateurConnecte = null;
    $idUtilisateur = $_SESSION['utilisateur_id'] ?? null;
    if (is_int($idUtilisateur)) {
        try {
            $utilisateurConnecte = trouverUtilisateurParId($connexion, $idUtilisateur);
        } catch (PDOException $erreur) {
            error_log('Vérification de la session impossible : ' . $erreur->getMessage());
            http_response_code(503);
            afficherVue('errors/503', [
                'titre' => 'Service temporairement indisponible',
                'pageCourante' => '',
            ]);
            return;
        }

        if ($utilisateurConnecte === null) {
            unset($_SESSION['utilisateur_id']);
        }
    }

    if ($utilisateurConnecte !== null && in_array($action, ['inscription', 'connexion'], true)) {
        header('Location: index.php?action=espace', true, 303);
        exit;
    }

    if ($action === 'espace' && $utilisateurConnecte === null) {
        header('Location: index.php?action=connexion', true, 303);
        exit;
    }

    match ($action) {
        'bienvenue' => afficherBienvenue($connexion),
        'inscription' => afficherInscription($connexion),
        'connexion' => afficherConnexion($connexion),
        'espace' => afficherEspace($utilisateurConnecte),
    };
}