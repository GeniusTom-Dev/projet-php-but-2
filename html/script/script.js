let growArrow = document.querySelector("#growArrow");
let article = document.querySelector('.article');

let heartRegular = document.querySelector("#heartRegular");
let bookmarkRegular = document.querySelector("#bookmarkRegular");

// Variable pour suivre l'état actuel de l'agrandissement
let isEnlarged = false;

let commentButton = document.querySelector("#comment-button");
let commentInput = document.querySelector("#comment-input");
//let commentsContainer = document.querySelector("#comments");
let commentsContainer = document.querySelector("#comment-section");

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
        commentElement.className = "comment";

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

        // Crée un élément de texte pour le commentaire
        let commentTextElement = document.createElement("div");
        commentTextElement.textContent = commentText;

        // Ajoute le bouton de suppression et le texte du commentaire à l'élément de commentaire
        commentElement.appendChild(deleteButton);
        commentElement.appendChild(commentTextElement);

        // Ajoute le commentaire à la section des commentaires
        commentsContainer.appendChild(commentElement);

        // Efface le contenu de la zone de texte
        commentInput.value = "";
    }
});
