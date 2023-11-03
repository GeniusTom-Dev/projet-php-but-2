let postContainers = document.querySelectorAll('.postInterface');

postContainers.forEach(value => {
    let trashCan = value.querySelector(".trashCan");
    let deleteConfirmation = value.querySelector(".deleteConfirmation");
    let confirmDeleteButton = value.querySelector(".confirmDeleteButton");
    let cancelDeleteButton = value.querySelector(".cancelDeleteButton");

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
})




