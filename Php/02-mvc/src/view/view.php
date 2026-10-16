<?php

// Fonction permettant d'appeler une vue et de lui passer
// les informations dont elle a besoin

function render(string $view, array $data): void
{
    // Extraire les données du tableau $data
    extract($data);

    // Utiliser le template de vue (layout.php)
    // Mise en tampon

    // 1. Démarrer la mise en tampon
    ob_start();
    // 2. Inclure la vue demandée
    require_once __DIR__ . "/../../views/" . $view . '.php';
    // 3. Récupérer le contenu de la vue stocké dans le tampon
    $content = ob_get_clean();
    // Appeler le layout
    require_once __DIR__ . "/../../views/layout.php";
}