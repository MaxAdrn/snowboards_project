const boutonMenu = document.querySelector("#bouton_menu");
const menuSection = document.querySelector(".menu_section");

boutonMenu.addEventListener("click", () => {
    menuSection.classList.toggle("visible");
});

const boutonCompte = document.querySelector("#bouton_compte");
const liensCompte = document.querySelector(".liens-compte");

boutonCompte.addEventListener("click", () => {
    liensCompte.classList.toggle("visible");
});
