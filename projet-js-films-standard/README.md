# Gestionnaire de Films

## 📋 Description

Application web permettant de gérer une collection de films. Développée en HTML, CSS et JavaScript natif, sans dépendances externes.

## 🎯 Fonctionnalités

- ✅ **Ajouter un film** : Création d'un film avec validation des données
- ✅ **Afficher la collection** : Visualisation de tous les films enregistrés
- ✅ **Supprimer un film** : Suppression unitaire d'un film
- ✅ **Vider la collection** : Suppression complète de tous les films
- ✅ **Validation du formulaire** : Messages d'erreur clairs et immédiats
- ✅ **Interface responsive** : Adaptation à tous les écrans
- ✅ **Navigation au clavier** : Accessibilité complète

## 📊 Structure des données

Chaque film est un objet contenant :

```javascript
{
  id: 1,
  titre: "Exemple",
  realisateur: "Nom",
  annee: 2024,
  duree: 120,
  genre: "Action"
}
```

## 🎬 Règles de validation

| Champ | Règle à respecter | Message d'erreur |
|-------|-------|------------------|
| **Titre** | Minimum 2 caractères (espaces ignorés) | Le titre doit contenir au moins 2 caractères. |
| **Réalisateur** | Minimum 2 caractères (espaces ignorés) | Le réalisateur doit contenir au moins 2 caractères. |
| **Année** | Entre 1895 et l'année actuelle | L'année doit être comprise entre 1895 et [année]. |
| **Durée** | Nombre entier > 0 | La durée doit être un entier supérieur à 0. |
| **Genre** | Sélection obligatoire | Veuillez sélectionner un genre. |

### Genres disponibles
- Action
- Comédie
- Drame
- Science-fiction
- Thriller
- Animation

## 📁 Structure du projet

```
projet-js-films-standard/
├── index.html          # Structure HTML du formulaire et de la collection
├── style.css           # Mise en forme et styles responsive
├── script.js           # Logique JavaScript, validation, gestion, événements
└── README.md           # Ce fichier
```

## 🚀 Lancement

1. Ouvrir le fichier `index.html` dans un navigateur web (Chrome, Firefox, Safari, Edge...)
2. Aucun serveur n'est nécessaire
3. L'application fonctionne 100% en local dans le navigateur

### Depuis le navigateur
- Clic droit sur `index.html` → Ouvrir avec → Sélectionner un navigateur
- Ou faire glisser `index.html` dans une fenêtre de navigateur ouverte

## 💻 Utilisation

### Ajouter un film
1. Remplir tous les champs du formulaire
2. Cliquer sur **Ajouter**
3. Si une erreur s'affiche, corriger le champ concerné
4. Le film apparaît dans la collection et le formulaire se réinitialise

### Supprimer un film
- Cliquer sur le bouton **Supprimer** d'un film

### Vider la collection
- Cliquer sur **Tout supprimer** (n'apparaît que s'il y a des films)

### Réinitialiser le formulaire
- Cliquer sur le bouton **Réinitialiser** (efface tous les champs sans ajout)

## 🎨 Design

- **Palette de couleurs** :
  - Bleu (#0066cc) : action principale
  - Gris (#999) : actions secondaires
  - Rouge (#d32f2f) : suppressions et erreurs
  - Blanc et gris clair : fond et cartes

- **Typographie** : System font (Segoe UI, Roboto, etc.)
- **Responsive** : Mobile, tablette et desktop
- **Accessibilité** : Navigation au clavier, états de focus visibles

## 🧪 Scénarios de test

| Test | Action | Résultat attendu |
|------|--------|------------------|
| T01 | Ouvrir l'app | Message "Aucun film enregistré" |
| T02 | Soumettre vide | Erreurs sur tous les champs |
| T03 | Film valide | Film affiché, formulaire réinitialisé |
| T04 | 2 films | Deux films visibles |
| T05 | Supprimer un film | Seul le film cible disparaît |
| T06 | Tout supprimer | Collection vidée |
| T07 | Année future | Message d'intervalle autorisé |
| T08 | Corriger erreurs | Messages disparaissent |
| T09 | Réduire fenêtre | Pas de débordement horizontal |

## 📝 Code

### Architecture JavaScript

```javascript
// Données
let films = [];

// Validation
function validerTitre(titre) { ... }
function validerFormulaire() { ... }

// Gestion
function ajouterFilm(film) { ... }
function supprimerFilm(id) { ... }

// Affichage
function afficherCollection() { ... }
function creerCarteFilm(film) { ... }

// Événements
filmForm.addEventListener('submit', ...);
```

### Qualités du code
- ✅ Fonction unique, responsable bien définie
- ✅ Noms explicites et constants clairement identifiés
- ✅ Indentation régulière et cohérente
- ✅ Pas de duplication inutile
- ✅ Commentaires pour les sections principales
- ✅ Validation robuste et gestion d'erreurs

## 🔧 Technologies

- **HTML5** : Structure sémantique
- **CSS3** : Flexbox, Grid, Media queries, Transitions
- **JavaScript ES6** : Classes implicites, méthodes natives

## 📌 Notes importantes

- ✅ Aucune dépendance externe (pas de jQuery, React, etc.)
- ✅ Pas de modules (pas de import/export)
- ✅ Pas de serveur requis
- ✅ Compatible navigateurs modernes
- ✅ Les données sont stockées uniquement en mémoire (perdues au rafraîchissement)

## 🎓 Objectifs pédagogiques

Ce projet mobilise les compétences suivantes :

1. Structurer une page avec des balises HTML sémantiques.
2. Mettre en forme une interface claire et adaptable avec CSS.
3. Sélectionner et modifier des éléments du DOM en JavaScript.
4. Réagir aux actions de l’utilisateur grâce aux événements.
5. Créer, parcourir et transformer un tableau d’objets.
6. Valider des données et afficher des messages d’erreur utiles.
7. Tester méthodiquement une application web.