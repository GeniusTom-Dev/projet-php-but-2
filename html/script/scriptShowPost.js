let postContainer = document.querySelector('.postInterface');

let trashCan = postContainer.querySelector(".trashCan");
let deleteConfirmation = postContainer.querySelector(".deleteConfirmation");
let confirmDeleteButton = postContainer.querySelector(".confirmDeleteButton");
let cancelDeleteButton = postContainer.querySelector(".cancelDeleteButton");

trashCan.addEventListener("click", () => {
    // Affiche la boîte de confirmation
    deleteConfirmation.style.display = "block";
});

confirmDeleteButton.addEventListener("click", () => {
    // Cache la boîte de confirmation
    deleteConfirmation.style.display = "none";
});

cancelDeleteButton.addEventListener("click", () => {
    // Annule la suppression lorsque le bouton d'annulation est cliqué
    // Cache la boîte de confirmation
    deleteConfirmation.style.display = "none";
});


