<?php

require_once __DIR__ . "/../controller/filmController.php";

// Routeur

function routage(PDO $pdo): void
{
    // Récupérer les routes
    $routes = require_once __DIR__ . "/../../config/routes.php";

    // Détermination de l'action et de la méthode HTTP
    $action = $_GET['action'] ?? 'list';
    $method = $_SERVER['REQUEST_METHOD'] ?? "GET";

    // Vérifier si l'action est une action autorisée
    if (!array_key_exists($action, $routes)) {
        // erreur 404
        notFound();
        return;
    }

    // Vérifier si la méthode HTTP est autorisé pour l'action demandée
    if (!in_array($method, $routes[$action], true)) {
        // erreur 405
        notAllowed();
        return;
    }

    // Routage
    switch ($action) {
        case 'list':
            listFilms($pdo);
            break;
        case 'create':
            createFilm($pdo);
            break;
        case 'delete':
            deleteFilm($pdo);
            break;
    }
}

function notFound(): void
{
    http_response_code(404);
    echo "Page introuvable";
}

function notAllowed(): void
{
    http_response_code(405);
    echo "Méthode non autorisée";
}