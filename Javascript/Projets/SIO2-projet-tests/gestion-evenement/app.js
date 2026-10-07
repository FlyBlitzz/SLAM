const parent = document.querySelector("#parent");
const enfant = document.querySelector("#enfant");
const bouton = document.querySelector("#bouton");

// Ajouter des listeners
bouton.addEventListener("click", () => {
    console.log("1. Bouton cliqué !");
})

enfant.addEventListener("click", () => {
    console.log("2. Section cliqué !");
})

parent.addEventListener("click", () => {
    console.log("3. Parent cliqué !");
})