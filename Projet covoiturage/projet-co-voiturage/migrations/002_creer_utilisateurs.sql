CREATE TABLE utilisateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT NOT NULL COLLATE NOCASE UNIQUE, --//COLLATE NOCASE rend la comparaison insensible à la casse, ce qui est utile pour les adresses e-mail
    telephone TEXT NOT NULL,
    mot_de_passe TEXT NOT NULL,
    cree_le TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO
    parametres (code)
SELECT 'CO-VOIT-PERGAUD'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM parametres
        WHERE
            code IS NOT NULL
            AND TRIM(code) <> ''
    );