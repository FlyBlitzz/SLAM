<?php

ini_set('session.use_strict_mode', '1'); // Empêche l’utilisation d’identifiants de session non générés par le serveur
ini_set('session.use_only_cookies', '1'); // Empêche l’utilisation d’identifiants de session dans l’URL
session_set_cookie_params([ // Paramètres de cookie pour la session
    'lifetime' => 0,
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);

// Vérifie que la session a bien démarré, sinon lève une exception.
if (!session_start()) {
    throw new RuntimeException('Impossible de démarrer la session.');
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Router/router.php';

$connexion = obtenirConnexion();
routerRequete($connexion);