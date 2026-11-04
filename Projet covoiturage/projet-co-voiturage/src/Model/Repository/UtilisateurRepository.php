<?php
//COLLATE NOCASE rend la comparaison insensible à la casse, ce qui est utile pour les adresses e-mail
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

function adresseEmailExiste(PDO $connexion, string $email): bool
{
    $requete = $connexion->prepare(
        'SELECT 1 FROM utilisateurs WHERE email = :email COLLATE NOCASE LIMIT 1'
    );
    $requete->execute(['email' => $email]);

    return $requete->fetchColumn() !== false;
}

function trouverUtilisateurPourConnexion(PDO $connexion, string $email): ?array
{
    $requete = $connexion->prepare(
        'SELECT id, nom, prenom, email, mot_de_passe
         FROM utilisateurs
         WHERE email = :email COLLATE NOCASE
         LIMIT 1'
    );
    $requete->execute(['email' => $email]);
    $utilisateur = $requete->fetch();

    return is_array($utilisateur) ? $utilisateur : null;
}

function trouverUtilisateurParId(PDO $connexion, int $id): ?array
{
    $requete = $connexion->prepare(
        'SELECT id, nom, prenom, email
         FROM utilisateurs
         WHERE id = :id
         LIMIT 1'
    );
    $requete->execute(['id' => $id]);
    $utilisateur = $requete->fetch();

    return is_array($utilisateur) ? $utilisateur : null;
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