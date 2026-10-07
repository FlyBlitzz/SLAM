<?php

// ------------------------------------------------------------
// Controleur frontal
// ------------------------------------------------------------

// Point d'entrée unique de l'application

// Récupération de la connexion à la base de données
require_once __DIR__ . "/../config/database.php";

require_once __DIR__ . "/../src/controller/filmController.php";

$pdo = getPDO();

// Identifier dans l'URL l'action à réaliser
$action = $_GET['action'] ?? 'list';

// Appeler le controleur qui traitera l'action demandé
// TODO

// switch ($action) {}

if ($action === 'list') {
    listFilms($pdo); // Appel au controller film
}