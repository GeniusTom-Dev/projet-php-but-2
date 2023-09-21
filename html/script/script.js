let growArrow = document.querySelector("#growArrow");
let article = document.querySelector('.article');

// Variable pour suivre l'état actuel de l'agrandissement
let isEnlarged = false;
growArrow.addEventListener("click", () => {
    if (!isEnlarged) {
        article.style.width = "50%"; /* Largeur agrandie */
        article.style.height = "70%"; /* Hauteur agrandie */
        article.style.backgroundColor = "transparent"; /* Fond transparent */
        article.style.zIndex = "2"; /* Affichage par-dessus les autres éléments */
        article.style.transition = "all 0.3s ease"; /* Transition fluide */
    } else {
        // Si l'article est déjà agrandi, rétrécis-le
        article.style.width = ""; /* Réinitialise la largeur */
        article.style.height = ""; /* Réinitialise la hauteur */
        article.style.backgroundColor = "#f0f0f0"; /* Couleur de fond d'origine */
        article.style.zIndex = ""; /* Réinitialise l'affichage */
    }

    // Inverse l'état de l'agrandissement
    isEnlarged = !isEnlarged;
});
