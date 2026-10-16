/**
 * ==============================================================================
 * TP JavaScript — BTS SIO 2ème Année
 * Sujet : Le Registre des Anomalies Mystiques (GlitchZero)
 * Fichier : app.js
 * 
 * Contraintes respectées :
 * 1. In-Memory State (Gestion d'état purement en mémoire, pas de stockage persistant)
 * 2. Génération déclarative (Array.prototype.map + join('') injecté dans innerHTML)
 * 3. Filtrage non destructif via Array.prototype.filter()
 * 4. Optimisation événementielle (Délégation d'événements & Event Bubbling)
 * 5. Bonus 1 : Cagnotte totale calculée via Array.prototype.reduce()
 * 6. Bonus 2 : Recherche textuelle multicritère (titre & description)
 * ==============================================================================
 */

// ==============================================================================
// 1. ÉTAT DE L'APPLICATION (IN-MEMORY STATE)
// ==============================================================================

/**
 * Jeu d'essai initial (au moins 3 objets prédéfinis respectant le modèle attendu)
 * L'utilisation de const garantit la référence constante au tableau.
 */
const bugs = [
  {
    id: 1711200001,
    titre: "Le CSS fantôme",
    auteur: "Alexandre",
    severite: "Critique",
    description: "La navbar disparaît uniquement les soirs de pleine lune sur Safari iOS.",
    recompense: 150
  },
  {
    id: 1711200002,
    titre: "Bouton de validation volant",
    auteur: "Sonia",
    severite: "Moyenne",
    description: "Le bouton se déplace de 20px vers la gauche dès qu'on essaie de le survoler avec la souris.",
    recompense: 75
  },
  {
    id: 1711200003,
    titre: "Faute de frappe dans le footer",
    auteur: "Thomas",
    severite: "Basse",
    description: "Mention « Tous droits réservés » écrite avec une coquille (« Tous drois réservés »).",
    recompense: 20
  }
];

/**
 * Variable globale représentant le filtre courant de sévérité.
 * Valeurs possibles : "Tous" | "Critique" | "Moyenne" | "Basse"
 */
let filtreActif = "Tous";

/**
 * Variable globale pour le mot-clé de recherche (Bonus)
 */
let rechercheTerme = "";

// ==============================================================================
// 2. SÉLECTION DES ÉLÉMENTS DU DOM
// ==============================================================================
const bugGrid = document.getElementById("bug-grid");
const counterBugs = document.getElementById("counter-bugs");
const totalBountyEl = document.getElementById("total-bounty");
const filterBar = document.getElementById("filter-bar");
const bugForm = document.getElementById("bug-form");
const searchInput = document.getElementById("search-input");
const btnClearSearch = document.getElementById("btn-clear-search");

// ==============================================================================
// 3. UTILITAIRES D'AFFICHAGE & SÉCURITÉ
// ==============================================================================

/**
 * Sécurise les entrées textuelles contre les failles XSS
 * avant injection dans les templates HTML.
 * @param {string} str - La chaîne brute saisie par l'utilisateur
 * @returns {string} - La chaîne échappée
 */
const escapeHTML = (str = "") => {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
};

/**
 * Affiche une brève notification toast dans l'interface
 * @param {string} message - Message à afficher
 * @param {"success" | "resolve"} type - Type visuel du toast
 */
const showToast = (message, type = "success") => {
  let toastContainer = document.querySelector(".toast-container");
  if (!toastContainer) {
    toastContainer = document.createElement("div");
    toastContainer.className = "toast-container";
    document.body.appendChild(toastContainer);
  }

  const toast = document.createElement("div");
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <span>${type === "resolve" ? "⚔️" : "✨"}</span>
    <span>${escapeHTML(message)}</span>
  `;

  toastContainer.appendChild(toast);

  // Disparition automatique après 3.2 secondes
  setTimeout(() => {
    toast.style.opacity = "0";
    toast.style.transform = "translateY(15px)";
    toast.style.transition = "all 0.3s ease";
    setTimeout(() => toast.remove(), 300);
  }, 3200);
};

// ==============================================================================
// 4. MOTEUR DE RENDU DÉCLARATIF (filter, map & join)
// ==============================================================================

/**
 * Fonction maîtresse chargée de synchroniser l'affichage avec l'état de l'application.
 * 1. Filtrage non destructif via .filter()
 * 2. Génération déclarative des templates HTML via .map() et .join('')
 * 3. Injection dans #bug-grid via innerHTML
 * 4. Mise à jour du compteur global et du bonus cagnotte (.reduce())
 */
const renderBugs = () => {
  // --- 1. Filtrage non destructif (filter) ---
  // On applique d'abord le filtre de sévérité
  let bugsFiltres = filtreActif === "Tous"
    ? bugs
    : bugs.filter((bug) => bug.severite.toLowerCase() === filtreActif.toLowerCase());

  // Combinaison avec le filtre de recherche textuelle (Bonus)
  if (rechercheTerme.trim() !== "") {
    const termeNormalise = rechercheTerme.trim().toLowerCase();
    bugsFiltres = bugsFiltres.filter((bug) => {
      const matchTitre = bug.titre.toLowerCase().includes(termeNormalise);
      const matchDesc = (bug.description || "").toLowerCase().includes(termeNormalise);
      const matchAuteur = bug.auteur.toLowerCase().includes(termeNormalise);
      return matchTitre || matchDesc || matchAuteur;
    });
  }

  // --- 2. Mise à jour des compteurs et du bonus cagnotte ---
  // Compteur global d'anomalies visibles
  counterBugs.textContent = bugsFiltres.length;

  // BONUS 1 : Cagnotte totale calculée via Array.prototype.reduce()
  const totalBounty = bugsFiltres.reduce((accumulateur, bug) => {
    return accumulateur + (Number(bug.recompense) || 0);
  }, 0);

  // Formatage du nombre avec séparateur de milliers
  totalBountyEl.textContent = totalBounty.toLocaleString("fr-FR");

  // --- 3. Gestion de l'état vide (si aucun résultat) ---
  if (bugsFiltres.length === 0) {
    bugGrid.innerHTML = `
      <div class="empty-state">
        <div class="empty-icon">🛸</div>
        <h3 class="empty-title">Aucune anomalie mystique détectée</h3>
        <p class="empty-desc">
          Aucun ticket ne correspond au filtre de sévérité 
          <strong>« ${escapeHTML(filtreActif)} »</strong>
          ${rechercheTerme ? ` ou au mot-clé <strong>« ${escapeHTML(rechercheTerme)} »</strong>` : ""}.
        </p>
        <button type="button" id="btn-reset-filters" class="btn-reset-filters">
          Réinitialiser les filtres
        </button>
      </div>
    `;

    // Écouteur spécifique pour réinitialiser depuis l'état vide
    const btnReset = document.getElementById("btn-reset-filters");
    if (btnReset) {
      btnReset.addEventListener("click", () => {
        filtreActif = "Tous";
        rechercheTerme = "";
        searchInput.value = "";
        btnClearSearch.hidden = true;
        updateActiveFilterButton("Tous");
        renderBugs();
      });
    }
    return;
  }

  // --- 4. Génération déclarative des cartes avec .map() et .join('') ---
  const cardsHtml = bugsFiltres
    .map((bug) => {
      // Destructuration ES6 des propriétés du bug
      const { id, titre, auteur, severite, description, recompense } = bug;
      const severiteClass = severite.toLowerCase();

      return `
        <article class="card" data-card-id="${id}">
          <!-- En-tête de la carte : Badge sévérité & Prime -->
          <div class="card-header">
            <span class="badge-severite ${severiteClass}">
              <span class="filter-dot dot-${severiteClass}"></span>
              ${escapeHTML(severite)}
            </span>
            <span class="card-bounty" title="Prime accordée pour la résolution">
              ⚡ ${Number(recompense) || 0} pts
            </span>
          </div>

          <!-- Corps de la carte : Titre, description, auteur, ID -->
          <div class="card-body">
            <h3 class="card-title">${escapeHTML(titre)}</h3>
            <p class="card-description">
              ${escapeHTML(description || "Aucune description surnaturelle renseignée.")}
            </p>
            <div class="card-meta">
              <span class="author-chip">
                <span>👤</span> ${escapeHTML(auteur)}
              </span>
              <span class="bug-id-tag">#${id}</span>
            </div>
          </div>

          <!-- Pied de carte : Bouton Résoudre avec data-id requis -->
          <div class="card-footer">
            <button 
              type="button" 
              class="btn-resolve" 
              data-id="${id}"
              aria-label="Résoudre et supprimer le ticket ${id}"
            >
              <span>⚔️</span>
              <span>Résoudre</span>
            </button>
          </div>
        </article>
      `;
    })
    .join("");

  // Injection unique dans le DOM (performance optimale)
  bugGrid.innerHTML = cardsHtml;
};

// ==============================================================================
// 5. GESTION DU SYSTÈME DE FILTRAGE (Étape 3)
// ==============================================================================

/**
 * Met à jour la classe CSS .active sur les boutons de filtre
 * @param {string} filterValue - Valeur du filtre actif ("Tous", "Critique", ...)
 */
const updateActiveFilterButton = (filterValue) => {
  const filterButtons = filterBar.querySelectorAll(".btn-filter");
  filterButtons.forEach((btn) => {
    if (btn.dataset.filter.toLowerCase() === filterValue.toLowerCase()) {
      btn.classList.add("active");
    } else {
      btn.classList.remove("active");
    }
  });
};

/**
 * Délégation d'événements sur le conteneur des filtres
 */
filterBar.addEventListener("click", (event) => {
  const btn = event.target.closest(".btn-filter");
  if (!btn) return;

  const nouveauFiltre = btn.dataset.filter;
  if (!nouveauFiltre) return;

  // Mise à jour de la variable d'état
  filtreActif = nouveauFiltre;

  // Mise à jour visuelle du bouton actif
  updateActiveFilterButton(filtreActif);

  // Recalcule et réaffichage immédiat
  renderBugs();
});

// ==============================================================================
// 6. GESTION DU CHAMP DE RECHERCHE TEXTUELLE (Bonus 2)
// ==============================================================================
searchInput.addEventListener("input", (event) => {
  rechercheTerme = event.target.value;
  btnClearSearch.hidden = rechercheTerme.length === 0;
  renderBugs();
});

btnClearSearch.addEventListener("click", () => {
  searchInput.value = "";
  rechercheTerme = "";
  btnClearSearch.hidden = true;
  searchInput.focus();
  renderBugs();
});

// ==============================================================================
// 7. SAISIE ET AJOUT DE DONNÉES (Étape 4)
// ==============================================================================
bugForm.addEventListener("submit", (event) => {
  // Neutralisation du rechargement de page par défaut
  event.preventDefault();

  // Extraction et nettoyage des valeurs du formulaire
  const titreInput = document.getElementById("bug-titre");
  const auteurInput = document.getElementById("bug-auteur");
  const severiteInput = document.getElementById("bug-severite");
  const recompenseInput = document.getElementById("bug-recompense");
  const descriptionInput = document.getElementById("bug-description");

  const titre = titreInput.value.trim();
  const auteur = auteurInput.value.trim();
  const severite = severiteInput.value;
  const recompense = Number(recompenseInput.value) || 0;
  const description = descriptionInput.value.trim();

  // Validation minimale
  if (!titre || !auteur) {
    alert("Veuillez renseigner les champs obligatoires (Titre et Auteur).");
    return;
  }

  // Création du nouvel objet bug respectant le modèle attendu
  const newBug = {
    id: Date.now(), // Identifiant unique basé sur le timestamp
    titre,
    auteur,
    severite,
    description: description || "Aucune description fournie.",
    recompense
  };

  // Ajout au tableau source bugs en mémoire
  bugs.push(newBug);

  // Réinitialisation du formulaire
  bugForm.reset();

  // Valeur de récompense par défaut agréable
  recompenseInput.value = "50";

  // Notification utilisateur
  showToast(`Anomalie « ${newBug.titre} » enregistrée avec succès !`, "success");

  // Rafraîchissement de l'interface
  renderBugs();
});

// ==============================================================================
// 8. SUPPRESSION PAR DÉLÉGATION D'ÉVÉNEMENTS (Étape 5)
// ==============================================================================

/**
 * UN SEUL écouteur sur le conteneur parent (#bug-grid).
 * Grâce à l'Event Bubbling, le clic remonte depuis le bouton jusqu'au conteneur.
 */
bugGrid.addEventListener("click", (event) => {
  // 1. Vérifier si l'élément cliqué (ou l'un de ses enfants) est le bouton de résolution
  const btnResolve = event.target.closest(".btn-resolve");
  if (!btnResolve) return;

  // 2. Récupérer l'identifiant cible du bug via dataset (data-id)
  const bugId = Number(btnResolve.dataset.id);

  // 3. Trouver l'index correspondant dans le tableau source bugs
  const bugIndex = bugs.findIndex((b) => b.id === bugId);

  if (bugIndex !== -1) {
    const bugSupprime = bugs[bugIndex];

    // Suppression de l'objet dans le tableau source
    bugs.splice(bugIndex, 1);

    // Notification utilisateur
    showToast(`Anomalie « ${bugSupprime.titre} » éliminée de la prod !`, "resolve");

    // 4. Réexécuter renderBugs() pour recalculer l'affichage
    renderBugs();
  }
});

// ==============================================================================
// 9. INITIALISATION AU CHARGEMENT DE LA PAGE
// ==============================================================================
document.addEventListener("DOMContentLoaded", () => {
  // Premier rendu à partir des données prédéfinies
  renderBugs();
});

/**
1) État initial et variables globales
- bugs : tableau d’objets représentant les anomalies de départ.
- filtreActif : le filtre courant, par exemple "Tous", "Critique", "Moyenne", "Basse".
- rechercheTerme : texte actuellement saisi dans la recherche.

Ces variables sont le cœur de l’application. Elles représentent l’état de l’application, et la vue est recalculée à chaque modification.

2) Sélection du DOM
Le script récupère des éléments HTML du document :
- bugGrid : conteneur où les cartes sont affichées
- counterBugs : compteur de bugs visibles
- totalBountyEl : total de la cagnotte
- filterBar : barre des filtres
- bugForm : formulaire d’ajout
- searchInput : champ de recherche
- btnClearSearch : bouton de remise à zéro

3) escapeHTML(str)
But :
- sécuriser les textes avant de les injecter dans le HTML avec innerHTML.

Rôle :
- remplace les caractères HTML dangereux par des entités :
  - & => &amp;
  - < => &lt;
  - > => &gt;
  - " => &quot;
  - ' => &#039;

Pourquoi c’est important :
- évite les failles XSS si un utilisateur entre du texte contenant du HTML ou du JavaScript.

4) showToast(message, type)
But :
- afficher une notification visuelle de type "succès" ou "résolution".

Détail :
- vérifie s’il existe déjà un conteneur .toast-container
- sinon, en crée un
- crée un élément div de toast
- injecte un emoji et le message
- l’ajoute au DOM
- puis l’efface automatiquement après 3,2 secondes avec un effet de disparition

Exemple :
- "Anomalie enregistrée avec succès !"
- "Anomalie éliminée de la prod !"

5) renderBugs()
C’est la fonction centrale du script.

Elle :
- applique les filtres,
- recalcule le nombre de résultats,
- calcule la cagnotte totale,
- gère l’état vide,
- génère les cartes HTML,
- et les injecte dans le DOM.

Étape 1 : filtrage
- si filtreActif est "Tous", on prend tous les bugs
- sinon, on ne garde que ceux dont severite correspond au filtre

Ensuite :
- si rechercheTerme n’est pas vide, on filtre aussi par :
  - titre
  - description
  - auteur

Cela donne un tableau bugsFiltres qui est une copie filtrée de bugs, sans modifier le tableau original. C’est la logique “non destructif”.

Étape 2 : compteur et cagnotte
- counterBugs.textContent = bugsFiltres.length
- totalBounty = bugsFiltres.reduce(...)
- reduce() additionne toutes les récompenses des bugs visibles
- totalBountyEl affiche la somme avec le bon format FR : ex. 245 pts => "245"

Étape 3 : cas “aucun résultat”
Si aucun bug ne correspond :
- on remplace le contenu de bugGrid par un état vide
- avec message :
  - “Aucune anomalie mystique détectée”
- on affiche un bouton “Réinitialiser les filtres”

Ce bouton appelle :
- filtreActif = "Tous"
- rechercheTerme = ""
- remise du champ de recherche à zéro
- mise à jour du bouton actif
- renderBugs()

Étape 4 : génération des cartes
Ensuite, on fait :
- bugsFiltres.map(...)
- chaque bug devient une chaîne HTML représentant une carte

Chaque carte contient :
- le niveau de sévérité avec badge
- la prime
- le titre
- la description
- l’auteur
- l’identifiant
- un bouton "Résoudre"

Puis :
- .join("") réunit toute la chaîne
- bugGrid.innerHTML = cardsHtml injecte le rendu final dans le DOM

Cette technique est appelée “génération déclarative” : on construit le HTML sous forme de données, puis on l’insère d’un coup.

6) updateActiveFilterButton(filterValue)
But :
- mettre à jour visuellement le filtre actif dans la barre.

Rôle :
- sélectionne tous les boutons .btn-filter
- compare leur data-filter avec le filtre courant
- ajoute la classe active sur le bon bouton
- retire active sur les autres

C’est ce qui permet de montrer visuellement quel filtre est sélectionné.

7) filterBar.addEventListener("click", ...)
C’est de la délégation d’événements.
Au lieu d’ajouter un écouteur à chaque bouton, on écoute le conteneur parent.

Processus :
- on vérifie si le clic vient d’un bouton .btn-filter
- on récupère sa valeur data-filter
- on met filtreActif à cette valeur
- on appelle updateActiveFilterButton()
- puis renderBugs()

C’est optimal : un seul écouteur pour tous les filtres.

8) searchInput.addEventListener("input", ...)
Quand l’utilisateur tape dans le champ de recherche :
- on met rechercheTerme = event.target.value
- on affiche ou masque le bouton de suppression
- on relance renderBugs()

Donc la recherche est dynamique : à chaque lettre tapée, l’affichage se met à jour.

9) btnClearSearch.addEventListener("click", ...)
Quand on clique sur le bouton "effacer la recherche" :
- vide le champ
- remet rechercheTerme à ""
- cache le bouton
- replace le focus dans le champ
- relance renderBugs()

10) bugForm.addEventListener("submit", ...)
C’est le formulaire d’ajout d’une anomalie.

Processus :
- event.preventDefault() pour empêcher le rechargement de page
- lire les champs :
  - titre
  - auteur
  - sévérité
  - récompense
  - description
- trim() pour supprimer les espaces
- validation minimale :
  - titre et auteur obligatoires
  - sinon alert("Veuillez renseigner ...")

Ensuite :
- on crée un nouvel objet avec :
  - id: Date.now()
  - titre
  - auteur
  - severite
  - description ou texte par défaut
  - recompense

Puis :
- bugs.push(newBug) ajoute l’objet au tableau
- bugForm.reset() vide le formulaire
- recompenseInput.value = "50" remet une valeur par défaut
- showToast(...) affiche une notification
- renderBugs() rafraîchit l’affichage

Cette fonction est le point d’entrée de la création de données.

11) bugGrid.addEventListener("click", ...)
C’est aussi une délégation d’événements, cette fois pour les boutons “Résoudre”.

Processus :
- on vérifie si le clic vient d’un bouton .btn-resolve
- on récupère l’identifiant depuis data-id
- on trouve l’index du bug dans bugs avec findIndex
- si trouvé :
  - on garde une copie du bug supprimé
  - on le retire du tableau avec splice()
  - on affiche une notification de suppression
  - on relance renderBugs()

Le point important est que le clic est capté sur le conteneur global, pas sur chaque bouton individuellement.

12) document.addEventListener("DOMContentLoaded", ...)
C’est l’initialisation finale.
Quand la page est complètement chargée :
- on exécute renderBugs() une première fois

Cela affiche les anomalies initiales présentes dans bugs.
*/