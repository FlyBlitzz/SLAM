# Version monolithique améliorée (multi-pages, sans MVC)

Cette version représente une étape intermédiaire classique entre le **monolithe tout-en-un** (`01-monolithique`) et l'**architecture MVC** (`02-mvc-procedural`).

## Caractéristiques et améliorations

1. **Découpage par pages (multi-pages)** :
   - `index.php` : page dédiée à la consultation (liste des films) avec bouton d'accès à la création.
   - `creer.php` : page dédiée au formulaire d'ajout et au traitement POST du nouveau film.
   - Navigation bidirectionnelle claire entre la liste et le formulaire.

2. **Mutualisation de la connexion BD (`db.php`)** :
   - La configuration PDO SQLite et l'initialisation automatique sont centralisées dans `db.php` au lieu d'être copiées-collées dans chaque page.

3. **Pattern Post-Redirect-Get (PRG)** :
   - Après insertion réussie dans `creer.php`, une redirection HTTP (`Location: index.php?created=1`) évite les doubles soumissions lors du rafraîchissement (F5).
   - Un message de confirmation s'affiche sur la page de liste.

4. **Pourquoi ce n'est toujours PAS du MVC ?**
   - **Pas de contrôleur frontal unique** : chaque fichier `.php` est directement appelé par son URL (`index.php`, `creer.php`).
   - **Pas de séparation Modèle / Vue / Contrôleur** : chaque page s'occupe de recevoir la requête, préparer ou exécuter le SQL, et générer le code HTML dans le même fichier.

## Lancer cette version

Depuis le dossier `02-monolithique-ameliore` :

```bash
php -S localhost:8000
```

Puis ouvrir dans votre navigateur :
```text
http://localhost:8000
```
