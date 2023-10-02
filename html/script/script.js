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
        deleteButton.textContent = "Supprimer";
        deleteButton.style.backgroundColor = "#ff6347"; /* Couleur de fond du bouton de suppression */
        deleteButton.style.color = "white"; /* Couleur du texte du bouton de suppression */
        deleteButton.style.border = "none"; /* Supprime la bordure du bouton de suppression */
        deleteButton.style.borderRadius = "5px"; /* Coins arrondis du bouton de suppression */
        deleteButton.style.padding = "5px 10px"; /* Espacement interne du bouton de suppression */
        deleteButton.style.cursor = "pointer"; /* Curseur pointeur au survol du bouton de suppression */
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

growArrow.addEventListener("click", () => {
    if (!isEnlarged) {
        article.style.width = "60%"; /* Largeur agrandie */
        article.style.height = "70%"; /* Hauteur agrandie */
    } else {
        // Si l'article est déjà agrandi, rétrécis-le
        article.style.width = ""; /* Réinitialise la largeur */
        article.style.height = ""; /* Réinitialise la hauteur */
    }

    // Inverse l'état de l'agrandissement
    isEnlarged = !isEnlarged;
});
heartRegular.addEventListener("click", () => {
    if (!isEnlarged) {
        // Remplace l'image initiale par la nouvelle image
        heartRegular.src = "/html/images/heart-solid.svg";
        heartRegular.style.transform = "scale(1.2)";
    } else {
        // Revert à l'image initiale
        heartRegular.src = "/html/images/heart-regular.svg";
        heartRegular.style.transform = "";
    }

    // Inverse l'état de l'agrandissement
    isEnlarged = !isEnlarged;
});

bookmarkRegular.addEventListener("click", () => {
    if (!isEnlarged) {
        // Remplace l'image initiale par la nouvelle image
        bookmarkRegular.src = "/html/images/bookmark-solid.svg";
        bookmarkRegular.style.transform = "scale(1.2)";
    } else {
        // Revert à l'image initiale
        bookmarkRegular.src = "/html/images/bookmark-regular.svg";
        bookmarkRegular.style.transform = "";
    }

    // Inverse l'état de l'agrandissement
    isEnlarged = !isEnlarged;
});

commentButton.addEventListener("click", () => {
    // Récupère le contenu du commentaire
    let commentText = commentInput.value;

    if (commentText.trim() !== "") {
        // Crée un nouvel élément de commentaire
        let commentElement = document.createElement("div");
        commentElement.className = "comment flex justify-between items-center mb-2";

        // Crée un élément de texte pour le commentaire
        let commentTextElement = document.createElement("div");
        commentTextElement.className = "mr-2"; // Ajoute un peu d'espace entre le texte du commentaire et le bouton
        commentTextElement.textContent = commentText;
        commentTextElement.style.wordWrap = "break-word"; // Ajoute la propriété CSS pour le débordement de texte

        // Crée un bouton de suppression pour le commentaire
        let deleteButton = document.createElement("button");
        deleteButton.textContent = "Supprimer";
        deleteButton.textContent = "Supprimer";
        deleteButton.style.backgroundColor = "#ff6347"; /* Couleur de fond du bouton de suppression */
        deleteButton.style.color = "white"; /* Couleur du texte du bouton de suppression */
        deleteButton.style.border = "none"; /* Supprime la bordure du bouton de suppression */
        deleteButton.style.borderRadius = "5px"; /* Coins arrondis du bouton de suppression */
        deleteButton.style.padding = "5px 10px"; /* Espacement interne du bouton de suppression */
        deleteButton.style.cursor = "pointer"; /* Curseur pointeur au survol du bouton de suppression */
        deleteButton.addEventListener("click", () => {
            // Supprime le commentaire lorsque le bouton de suppression est cliqué
            commentsContainer.removeChild(commentElement);
        });

        // Ajoute le bouton de suppression et le texte du commentaire à l'élément de commentaire
        commentElement.appendChild(commentTextElement);
        commentElement.appendChild(deleteButton);

        // Ajoute le commentaire à la section des commentaires
        commentsContainer.appendChild(commentElement);

        // Efface le contenu de la zone de texte
        commentInput.value = "";
    }
});
