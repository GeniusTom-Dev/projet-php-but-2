let growArrow = document.querySelector("#growArrow");
let article = document.querySelector('.article');

let heartRegular = document.querySelector("#heartRegular");
//let heartSolid = document.querySelector("#heartSolid");

let bookmarkRegular = document.querySelector("#bookmarkRegular");
//let bookmarkSolid = document.querySelector("#bookmarkSolid");

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
