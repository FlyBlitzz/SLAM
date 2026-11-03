<?php

function obtenirCodeInscription(PDO $connexion): ?string
{
    $requete = $connexion->query(
        "SELECT code FROM parametres
         WHERE code IS NOT NULL AND TRIM(code) <> ''
         ORDER BY rowid DESC -- rowid est un identifiant unique croissant pour chaque ligne, donc le dernier code inséré sera en haut
         LIMIT 1"
    );
    $code = $requete->fetchColumn();

    return is_string($code) ? trim($code) : null;
}

function creerUtilisateur(
    PDO $connexion,
    string $nom,
    string $prenom,
    string $email,
    string $telephone,
    string $motDePasse
): void {
    $requete = $connexion->prepare(
        'INSERT INTO utilisateurs (nom, prenom, email, telephone, mot_de_passe)
         VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe)'
    );
    $requete->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone,
        'mot_de_passe' => password_hash($motDePasse, PASSWORD_DEFAULT),
    ]);
}