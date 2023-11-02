let growArrow = document.querySelector("#growArrow");
let article = document.querySelector('.article');

let heartRegular = document.querySelector("#heartRegular");
let bookmarkRegular = document.querySelector("#bookmarkRegular");

// Variable pour suivre l'état actuel de l'agrandissement
let isEnlarged = false;

let commentButton = document.querySelector("#comment-button");
let commentInput = document.querySelector("#comment-input");
let commentsContainer = document.querySelector("#comment-section");

let plusButton = document.querySelector("#plusButton");
let fileInput = document.querySelector("#fileInput");

let suscribeButton = document.querySelector("#suscribe-button");

// Variable pour suivre l'état actuel de l'abonnement
let isSubscribed = false;

let trashCan = document.querySelector("#trashCan");
let deleteConfirmation = document.querySelector("#deleteConfirmation");
let confirmDeleteButton = document.querySelector("#confirmDeleteButton");
let cancelDeleteButton = document.querySelector("#cancelDeleteButton");


plusButton.addEventListener("click", () => {
    fileInput.click();
});

fileInput.addEventListener("change", (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
        // Créez un conteneur pour l'image et le bouton de suppression
        const imageContainer = document.createElement("div");
        imageContainer.className = "flex items-center";

        // Créez un élément img pour afficher l'image
        const imgElement = document.createElement("img");
        imgElement.src = URL.createObjectURL(selectedFile);
        imgElement.className = "w-32 h-auto"; // Ajustez la taille de l'image selon vos besoins

        // Créez un bouton de suppression pour l'image
        const deleteButton = document.createElement("button");
        deleteButton.style.background = "url('/Projet/projet-php-but-2/html/images/trash-can-solid.svg')"; /* Remplacez 'votre-image.png' par le chemin de votre image */
        //deleteButton.style.backgroundSize = "cover"; /* Ajustez la taille de l'image selon vos besoins */
        deleteButton.style.padding = "10px 9px";
        deleteButton.addEventListener("click", () => {
            // Supprime l'image et le bouton de suppression lorsque le bouton est cliqué
            imageContainer.remove();
        });

        // Ajoutez l'image et le bouton de suppression au conteneur
        imageContainer.appendChild(imgElement);
        imageContainer.appendChild(deleteButton);

        // Ajoutez le conteneur à un conteneur de galerie sur votre page
        const galleryContainer = document.querySelector("#galleryContainer");
        galleryContainer.appendChild(imageContainer);
    }
});

