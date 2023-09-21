let growArrow = document.querySelector("#growArrow");
let article = document.querySelector('.article');

// Variable pour suivre l'état actuel de l'agrandissement
let isEnlarged = false;
growArrow.addEventListener("click", () => {
    if (!isEnlarged) {
        article.style.width = "50%"; /* Largeur agrandie */
        article.style.height = "70%"; /* Hauteur agrandie */
    } else {
        // Si l'article est déjà agrandi, rétrécis-le
        article.style.width = ""; /* Réinitialise la largeur */
        article.style.height = ""; /* Réinitialise la hauteur */
    }

    // Inverse l'état de l'agrandissement
    isEnlarged = !isEnlarged;
});
