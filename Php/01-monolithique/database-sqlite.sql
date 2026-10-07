DROP TABLE IF EXISTS films;

CREATE TABLE films (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titre TEXT NOT NULL,
    realisateur TEXT NOT NULL
);

INSERT INTO films (titre, realisateur) VALUES
('Alien', 'Ridley Scott'),
('Inception', 'Christopher Nolan'),
('Le Fabuleux Destin d''Amélie Poulain', 'Jean-Pierre Jeunet');
