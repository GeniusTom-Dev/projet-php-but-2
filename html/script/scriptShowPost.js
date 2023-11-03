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

// Sélectionnez la zone de texte et le bouton
const categoryInput = document.getElementById("category-input");
const addCategoryButton = document.getElementById("add-category-button");
const categoryList = document.getElementById("category-list");


// Sélectionnez le bouton "Poster" par son ID
const postButton = document.getElementById("submit-post-button");

// Sélectionnez le champ de texte pour le titre par son ID
const titleInput = document.getElementById("title-input");

// Sélectionnez la zone de texte pour le contenu par son ID
const contentInput = document.getElementById("post-content");

// Sélectionnez la div où vous souhaitez afficher les titres et le contenu
const postedContent = document.getElementById("posted-content");


trashCan.addEventListener("click", () => {
    // Affiche la boîte de confirmation
    deleteConfirmation.style.display = "block";
});

confirmDeleteButton.addEventListener("click", () => {
    // Sélectionnez l'article actuel
    const currentArticle = document.getElementById("article");

    // Delete post in database

    // Supprimez l'article sur la page
    currentArticle.parentNode.removeChild(currentArticle);

    // Après la suppression, cache la boîte de confirmation
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
});
heartRegular.addEventListener("click", () => {
    // add like to database

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
    // add fav to database

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
        deleteButton.style.backgroundColor = "#ff6347"; /* Couleur de fond du bouton de suppression */
        deleteButton.style.color = "white"; /* Couleur du texte du bouton de suppression */
        deleteButton.style.border = "none"; /* Supprime la bordure du bouton de suppression */
        deleteButton.style.borderRadius = "5px"; /* Coins arrondis du bouton de suppression */
        deleteButton.style.padding = "5px 10px"; /* Espacement interne du bouton de suppression */
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