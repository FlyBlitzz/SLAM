// ===========================
// Collection et données
// ===========================

let films = [];
let nextId = 1;

// ===========================
// Références du DOM
// ===========================

const filmForm = document.getElementById("filmForm");
const titreInput = document.getElementById("titre");
const realisateurInput = document.getElementById("realisateur");
const anneeInput = document.getElementById("annee");
const dureeInput = document.getElementById("duree");
const genreInput = document.getElementById("genre");

const erreurTitre = document.getElementById("erreurTitre");
const erreurRealisateur = document.getElementById("erreurRealisateur");
const erreurAnnee = document.getElementById("erreurAnnee");
const erreurDuree = document.getElementById("erreurDuree");
const erreurGenre = document.getElementById("erreurGenre");

const filmsList = document.getElementById("filmsList");
const deleteAllBtn = document.getElementById("deleteAllBtn");

// ===========================
// Validation
// ===========================

function validerTitre(titre) {
    const titreNettoye = titre.trim();
    return titreNettoye.length >= 2;
}

function validerRealisateur(realisateur) {
    const realisateurNettoye = realisateur.trim();
    return realisateurNettoye.length >= 2;
}

function validerAnnee(annee) {
    const anneeActuelle = new Date().getFullYear();
    const anneeNum = parseInt(annee, 10);

    if (isNaN(anneeNum)) {
        return false;
    }

    return anneeNum >= 1895 && anneeNum <= anneeActuelle;
}

function validerDuree(duree) {
    const dureeNum = parseInt(duree, 10);

    if (isNaN(dureeNum)) {
        return false;
    }

    return dureeNum > 0;
}

function validerGenre(genre) {
    return genre !== "";
}

function effacerErreurs() {
    erreurTitre.textContent = "";
    erreurRealisateur.textContent = "";
    erreurAnnee.textContent = "";
    erreurDuree.textContent = "";
    erreurGenre.textContent = "";
}

function validerFormulaire() {
    effacerErreurs();

    let formulaireValide = true;

    if (!validerTitre(titreInput.value)) {
        erreurTitre.textContent = "Le titre doit contenir au moins 2 caractères.";
        formulaireValide = false;
    }

    if (!validerRealisateur(realisateurInput.value)) {
        erreurRealisateur.textContent = "Le réalisateur doit contenir au moins 2 caractères.";
        formulaireValide = false;
    }

    if (!validerAnnee(anneeInput.value)) {
        const anneeActuelle = new Date().getFullYear();
        erreurAnnee.textContent = `L'année doit être comprise entre 1895 et ${anneeActuelle}.`;
        formulaireValide = false;
    }

    if (!validerDuree(dureeInput.value)) {
        erreurDuree.textContent = "La durée doit être un entier supérieur à 0.";
        formulaireValide = false;
    }

    if (!validerGenre(genreInput.value)) {
        erreurGenre.textContent = "Veuillez sélectionner un genre.";
        formulaireValide = false;
    }

    return formulaireValide;
}

// ===========================
// Gestion des films
// ===========================

function ajouterFilm(film) {
    film.id = nextId;
    nextId++;
    films.push(film);
    afficherCollection();
}

function supprimerFilm(id) {
    const index = films.findIndex(film => film.id === id);
    if (index !== -1) {
        films.splice(index, 1);
        afficherCollection();
    }
}

function supprimerTousLesFilms() {
    films = [];
    afficherCollection();
}

// ===========================
// Affichage
// ===========================

function afficherCollection() {
    if (films.length === 0) {
        filmsList.innerHTML = '<p class="empty-message">Aucun film enregistré.</p>';
    } else {
        filmsList.innerHTML = films.map(film => creerCarteFilm(film)).join("");

        filmsList.querySelectorAll(".btn-delete-film").forEach(bouton => {
            bouton.addEventListener("click", () => {
                supprimerFilm(parseInt(bouton.dataset.id, 10));
            });
        });
    }
}

function creerCarteFilm(film) {
    return `
        <div class="film-card">
            <div class="film-info">
                <div class="film-title">${film.titre}</div>
                <div class="film-detail">Réalisateur : ${film.realisateur}</div>
                <div class="film-detail">${film.annee} — ${film.duree} min</div>
                <div class="film-detail">Genre : ${film.genre}</div>
            </div>
            <div class="film-actions">
                <button class="btn-delete-film" data-id="${film.id}">Supprimer</button>
            </div>
        </div>
    `;
}

// ===========================
// Événements
// ===========================

filmForm.addEventListener("submit", (e) => {
    e.preventDefault();

    if (!validerFormulaire()) {
        return;
    }

    const film = {
        titre: titreInput.value.trim(),
        realisateur: realisateurInput.value.trim(),
        annee: parseInt(anneeInput.value, 10),
        duree: parseInt(dureeInput.value, 10),
        genre: genreInput.value
    };

    ajouterFilm(film);

    filmForm.reset();

    effacerErreurs();
});

deleteAllBtn.addEventListener("click", () => {
    supprimerTousLesFilms();
});

// ===========================
// Initialisation
// ===========================

document.addEventListener("DOMContentLoaded", () => {
    afficherCollection();
});