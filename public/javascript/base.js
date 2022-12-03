const boutonMenu = document.querySelector("#bouton_menu");
const menuSection = document.querySelector(".liste-menu");
const h1 = document.querySelector("h1");

boutonMenu.addEventListener("click", () => {
    menuSection.classList.toggle("visible");
    h1.classList.toggle("hindex");
});

const boutonCompte = document.querySelector("#bouton_compte");
const liensCompte = document.querySelector(".liste-compte");

boutonCompte.addEventListener("click", () => {
    liensCompte.classList.toggle("visible");
    h1.classList.toggle("hindex");
});