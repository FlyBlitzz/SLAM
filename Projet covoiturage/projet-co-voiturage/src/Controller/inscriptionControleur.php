<?php

require_once __DIR__ . '/../View/view.php';
require_once __DIR__ . '/../Model/Repository/UtilisateurRepository.php';

function afficherInscription(PDO $connexion): void
{
    $valeurs = [
        'nom' => '',
        'prenom' => '',
        'email' => '',
        'telephone' => '',
    ];
    $erreurs = [];
    $message = '';
    $inscriptionReussie = false;

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        foreach (array_keys($valeurs) as $champ) {
            $saisie = $_POST[$champ] ?? '';
            $valeurs[$champ] = is_string($saisie) ? trim($saisie) : '';
        }

        $motDePasse = $_POST['mot_de_passe'] ?? '';
        $codeInscription = $_POST['code_inscription'] ?? '';
        $motDePasse = is_string($motDePasse) ? $motDePasse : '';
        $codeInscription = is_string($codeInscription) ? trim($codeInscription) : '';

        foreach ([
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'email' => 'Adresse électronique',
            'telephone' => 'Numéro de téléphone',
        ] as $champ => $libelle) {
            if ($valeurs[$champ] === '') {
                $erreurs[$champ] = "Le champ « {$libelle} » est obligatoire.";
            }
        }

        if ($motDePasse === '') {
            $erreurs['mot_de_passe'] = 'Le mot de passe est obligatoire.';
        }

        if ($codeInscription === '') {
            $erreurs['code_inscription'] = 'Le code d’inscription est obligatoire.';
        }

        if (
            $valeurs['email'] !== ''
            && filter_var($valeurs['email'], FILTER_VALIDATE_EMAIL) === false
        ) {
            $erreurs['email'] = 'Veuillez saisir une adresse électronique valide.';
        } elseif (
            $valeurs['email'] !== ''
            && strtolower((string) strrchr($valeurs['email'], '@')) !== '@ac-besancon.fr'
        ) {
            $erreurs['email'] = 'Utilisez votre adresse académique se terminant par @ac-besancon.fr.';
        }

        if (
            $valeurs['telephone'] !== ''
            && preg_match('/^0[1-9](?:[ .-]?\d{2}){4}$/', $valeurs['telephone']) !== 1
        ) {
            $erreurs['telephone'] = 'Veuillez saisir un numéro de téléphone valide au format 06 12 34 56 78.';
        }

        if ($erreurs === []) {
            try {
                $codeAttendu = obtenirCodeInscription($connexion);
            } catch (PDOException $erreur) {
                error_log('Lecture du code d’inscription impossible : ' . $erreur->getMessage());
                $codeAttendu = null;
            }

            if ($codeAttendu === null) {
                $message = 'Le service d’inscription est indisponible. Réessayez plus tard.';
            } elseif (!hash_equals($codeAttendu, $codeInscription)) {
                $erreurs['code_inscription'] = 'Code d’inscription incorrect';
            } else {
                try {
                    creerUtilisateur(
                        $connexion,
                        $valeurs['nom'],
                        $valeurs['prenom'],
                        $valeurs['email'],
                        $valeurs['telephone'],
                        $motDePasse
                    );
                    $inscriptionReussie = true;
                } catch (PDOException $erreur) {
                    if ((int) ($erreur->errorInfo[1] ?? 0) === 19) {
                        $erreurs['email'] = 'Cette adresse électronique est déjà utilisée.';
                    } else {
                        error_log('Création du compte impossible : ' . $erreur->getMessage());
                        $message = 'Une erreur est survenue pendant la création du compte. Réessayez.';
                    }
                }
            }
        }
    }

    afficherVue('inscription/index', [
        'titre' => 'Créer un compte',
        'pageCourante' => 'inscription',
        'valeurs' => $valeurs,
        'erreurs' => $erreurs,
        'message' => $message,
        'inscriptionReussie' => $inscriptionReussie,
    ]);
}