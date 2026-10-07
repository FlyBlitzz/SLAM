const produits = [
    { id: 1, nom: "Clavier", prix: 49, stock: 12 },
    { id: 2, nom: "Souris", prix: 25, stock: 0 },
    { id: 3, nom: "Écran", prix: 179, stock: 5 }
];

// Afficher le nom de chaque produit
for (const produit of produits) {
    console.log(produit.nom);
}

// Version foreach
produits.forEach(produit => {
    console.log(produit.nom);
});

// Création d'un tableau contenant les noms des produits
const noms = produits.map(
    produit => produit.nom
);
console.log(noms);

// Récupérer tous les produits en stock
const disponibles = produits.filter(
    produit => { return produit.stock > 0 }
);
console.log(disponibles);