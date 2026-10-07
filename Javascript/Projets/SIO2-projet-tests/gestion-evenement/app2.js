const liste = document.querySelector("#liste");

const bouton = document.querySelectorAll("button");

/*
// Ajouter un listener (click) pour chaque bouton
bouton.forEach((bouton) => {
    bouton.addEventListener("click", () => {
        console.log("Bouton cliqué")
    })
})
*/

// Ajouter un listener (click) pour chaque bouton en utilisant
// la délégation d'événement (basée sur le bubbling)

// Déléguer le click sur chaque bouton à l'élément parent (liste)
liste.addEventListener("click", event => {
    console.log(event.target)
    console.log(event.currentTarget)

    // Récupérer le bouton sur lequel on a cliqué
    const boutonClique = event.target.closest("button");
    if (boutonClique) {
        console.log("Bouton cliqué :", boutonClique.textContent);
    }
})