<?php

// ------------------------------------------------------------
// Contrôleur frontal
// ------------------------------------------------------------

// Point d'entrée unique de l'application

// Récupération de la connexion à la base de données
require_once __DIR__ . "/../config/database.php";

require_once __DIR__ . "/../src/router/router.php";

$pdo = getPDO(); // Création de la connexion à la BDD

// Appel au router afin de déterminer l'action à réaliser et son traitement
routage($pdo);