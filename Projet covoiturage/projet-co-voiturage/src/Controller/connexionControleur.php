<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/../Model/Repository/UtilisateurRepository.php';

function afficherConnexion(PDO $connexion): void
{
    $email = '';
    $erreurs = [];
    $message = '';

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        $saisieEmail = $_POST['email'] ?? '';
        $email = is_string($saisieEmail) ? trim($saisieEmail) : '';
        $motDePasse = $_POST['mot_de_passe'] ?? '';
        $motDePasse = is_string($motDePasse) ? $motDePasse : '';

        if ($email === '') {
            $erreurs['email'] = 'L’adresse électronique est obligatoire.';
        }

        if ($motDePasse === '') {
            $erreurs['mot_de_passe'] = 'Le mot de passe est obligatoire.';
        }

        if ($erreurs === []) {
            try {
                $utilisateur = trouverUtilisateurPourConnexion($connexion, $email);
            } catch (PDOException $erreur) {
                error_log('Recherche du compte pour connexion impossible : ' . $erreur->getMessage());
                $message = 'La connexion est temporairement indisponible. Réessayez plus tard.';
                $utilisateur = null;
            }

            if ($message === '') {
                if (
                    $utilisateur === null
                    || !password_verify($motDePasse, $utilisateur['mot_de_passe'])
                ) {
                    $message = 'Adresse électronique ou mot de passe incorrect';
                } elseif (!session_regenerate_id(true)) { // Renouveler l’identifiant de session pour éviter le vol de session
                    error_log('Impossible de renouveler l’identifiant de session après connexion.');
                    $message = 'La connexion est temporairement indisponible. Réessayez plus tard.';
                } else {
                    $_SESSION['utilisateur_id'] = (int) $utilisateur['id'];
                    header('Location: index.php?action=espace', true, 303);
                    exit;
                }
            }
        }
    }

    afficherVue('connexion/index', [
        'titre' => 'Se connecter',
        'pageCourante' => 'connexion',
        'email' => $email,
        'erreurs' => $erreurs,
        'message' => $message,
    ]);
}

function afficherEspace(array $utilisateur): void
{
    afficherVue('espace/index', [
        'titre' => 'Mon espace',
        'pageCourante' => 'espace',
        'utilisateur' => $utilisateur,
    ]);
}