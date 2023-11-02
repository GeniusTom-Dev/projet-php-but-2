
let trashCan = document.querySelector("#trashCan");
let deleteConfirmation = document.querySelector("#deleteConfirmation");
let confirmDeleteButton = document.querySelector("#confirmDeleteButton");
let cancelDeleteButton = document.querySelector("#cancelDeleteButton");

let plusButton = document.querySelector("#plusButton");
let fileInput = document.querySelector("#fileInput");

// Supprimer une publication en cliquant sur le bouton de suppression
function handleDeleteButtonClick(publicationId) {
    // Ici, vous devrez implémenter la logique pour supprimer la publication avec l'ID donné.
    // Cela peut inclure une demande AJAX au serveur pour supprimer la publication.

    // Pour cet exemple, nous allons simplement supprimer l'élément du DOM.
    const publicationElement = document.getElementById(`publication${publicationId}`);
    if (publicationElement) {
        publicationElement.remove();
    }
}

// Écouter les clics sur les boutons de suppression
document.addEventListener("click", (event) => {
    if (event.target && event.target.id.startsWith("deleteButton")) {
        const publicationId = event.target.id.replace("deleteButton", "");
        handleDeleteButtonClick(publicationId);
    }
});