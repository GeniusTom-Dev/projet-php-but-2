let postContainer = document.querySelector('.postInterface');

let growArrow = postContainer.querySelector(".growArrow");

let suscribeButton = postContainer.querySelector(".suscribe-button");

// Variable pour suivre l'état actuel de l'abonnement
let isSubscribed = false;

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


//S'abonner ou se désabonner
suscribeButton.addEventListener("click", () => {
    if (!isSubscribed) {
        // Si l'utilisateur n'est pas encore abonné
        suscribeButton.textContent = "Se désabonner"; // Change le texte du bouton
    } else {
        // Si l'utilisateur est déjà abonné et clique pour se désabonner
        suscribeButton.textContent = "S'abonner"; // Rétablit le texte d'origine
    }

    // Inverse l'état de l'abonnement
    isSubscribed = !isSubscribed;
});

growArrow.addEventListener("click", () => {
    // Bacullement sur page detail post
    location.href = "index.php";
});

