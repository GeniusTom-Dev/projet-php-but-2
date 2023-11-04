let postCreator = document.querySelector(".postCreationInterface");

let plusButton = postCreator.querySelector(".plusButton");
let fileInput = postCreator.querySelector(".fileInput");

let trashCan = postCreator.querySelector(".trashCan");
let deleteConfirmation = postCreator.querySelector(".deleteConfirmation");
let confirmDeleteButton = postCreator.querySelector(".confirmDeleteButton");
let cancelDeleteButton = postCreator.querySelector(".cancelDeleteButton");

// All topics related elements
const categoryInput = postCreator.querySelector(".categoryInput");
const addCategoryButton = postCreator.querySelector(".add-category-button");
//const categoryList = postCreator.querySelector(".category-list");

// Article gallery
const galleryContainer = postCreator.querySelector(".galleryContainer");
const imageInput = document.querySelector(".fileInputPP");


// Ajoutez un gestionnaire d'événement pour le bouton "Ajouter Catégorie"
addCategoryButton.addEventListener("click", () => {
    // Récupérez la valeur de la zone de texte
    const newCategory = categoryInput.value.trim();
    const allTopics = document.getElementById("topicsList");

    if (newCategory !== "" && document.getElementById("categoryList").children.length < 3) {
        const optionItems = allTopics.getElementsByTagName('li');
        for (let i = 0; i < optionItems.length; i++) {
            const option = optionItems[i].textContent.toLowerCase();
            if (option.includes(newCategory.toLowerCase())) {
                // Créez un élément p pour la nouvelle catégorie
                const categoryItem = document.createElement("p");
                const categoryItemInput = document.createElement("input");
                const categoryList = document.getElementById("categoryList");
                categoryItem.className = "bg-purple-500 text-white rounded-md px-2 py-1 m-1 justify-start text-left inline-block";
                categoryItem.textContent = newCategory;

                // Hidden input
                categoryItemInput.type = "hidden";
                categoryItemInput.name = "topics[]";
                categoryItemInput.value = newCategory;
                categoryItemInput.className = "topicItemInput";

                // Créez un bouton pour supprimer la catégorie
                const deleteButton = document.createElement("button");
                deleteButton.textContent = " X ";
                deleteButton.className = "bg-red-500 text-white rounded-md px-1 m-1";
                deleteButton.addEventListener("click", () => {
                    categoryItem.remove(); // Supprime la catégorie lorsque le bouton "Supprimer" est cliqué
                });

                // Ajoutez la catégorie et le bouton de suppression à la liste
                categoryItem.appendChild(deleteButton);
                categoryItem.appendChild(categoryItemInput);
                categoryList.appendChild(categoryItem);

                // Effacez le champ de texte
                categoryInput.value = "";
                return;
            }
        }
    }
});


trashCan.addEventListener("click", () => {
    // Affiche la boîte de confirmation
    deleteConfirmation.style.display = "block";
});

confirmDeleteButton.addEventListener("click", () => {
    location.href = "View/homepage.php";
});

cancelDeleteButton.addEventListener("click", () => {
    // Annule la suppression lorsque le bouton d'annulation est cliqué
    // Cache la boîte de confirmation
    deleteConfirmation.style.display = "none";
});

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
        deleteButton.addEventListener("click", () => {
            // Supprime l'image et le bouton de suppression lorsque le bouton est cliqué
            imageContainer.remove();
        });

        // Create hidden input for image url
        const imgURLInput = document.createElement("input")
        imgURLInput.type = "hidden";
        imgURLInput.name = "img[]";
        imgURLInput.value = imgElement.src;
        imgURLInput.className = "imgURLInput";

        // Ajoutez l'image et le bouton de suppression au conteneur
        imageContainer.appendChild(imgElement);
        imageContainer.appendChild(deleteButton);
        imageContainer.appendChild(imgURLInput);

        // Ajoutez le conteneur à un conteneur de galerie sur votre page
        galleryContainer.appendChild(imageContainer);
    }
});

