
// Variable pour suivre l'état actuel de l'agrandissement
let plusButton = document.querySelector("#plusButton");
let fileInput = document.querySelector("#fileInput");
const profilePicture = document.getElementById("profilePicture");
const profileImage = document.getElementById("profileImage");
let fileInputPP = document.querySelector("#fileInputPP");

let suscribeButton = document.querySelector("#suscribe-button");

// Variable bouton supprimer, et biographie
let trashCan = document.querySelector("#trashCan");
const bioContainer = document.getElementById("bioContainer");
    const bioForm = document.getElementById("bioForm");
    const userBio = document.getElementById("userBio");
    const editButton = document.getElementById("editButton");
    const editForm = document.getElementById("editForm");
    const bioTextArea = document.getElementById("bioTextArea");


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
        imgElement.className = "w-64 h-auto p-2 "; // Ajustez la taille de l'image selon vos besoins

        // Créez un bouton de suppression pour l'image
        const deleteButton = document.createElement("button");
        deleteButton.style.background = "url('/html/images/trash-can-solid.svg')"; /* Remplacez 'votre-image.png' par le chemin de votre image */
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

     // Fonction pour gérer l'état de modification
     function toggleEditMode() {
        const isEditing = bioForm.style.display === "block";
        bioForm.style.display = isEditing ? "none" : "block";
        bioContainer.style.display = isEditing ? "block" : "none";
        editButton.style.display = isEditing ? "block" : "none";
      }
  
 
      // Afficher le formulaire de modification de la bio
      editButton.addEventListener("click", () => {
        toggleEditMode();
      });
      bioTextArea.addEventListener('input', () => {
        const maxLength = bioTextArea.maxLength;
        const currentLength = bioTextArea.value.length;
        const remainingCharacters = maxLength - currentLength;
        
        charCount.textContent = `Caractères restants : ${remainingCharacters}`;
    });
  
      // Enregistrer la bio modifiée
      editForm.addEventListener("submit", (event) => {
        event.preventDefault();
        const newBio = bioTextArea.value;
        userBio.textContent = newBio;
        const maxLength = bioTextArea.maxLength;
        const currentLength = bioTextArea.value.length;
        
        if (currentLength > maxLength) {
            alert('La biographie dépasse la limite de caractères autorisée.');
            e.preventDefault(); // Empêcher la soumission du formulaire
        }
        toggleEditMode();
      });
    
       // Gérer le clic sur la photo de profil pour ouvrir le sélecteur de fichier
    profilePicture.addEventListener("click", () => {
        fileInputPP.click();
      });
  
      // Gérer le changement de la photo de profil lors de la sélection d'un fichier
      fileInputPP.addEventListener("change", (event) => {
        const selectedFile = event.target.files[0];
  
        if (selectedFile) {
          const profileImage = document.getElementById("profileImage");
  
          const reader = new FileReader();
          reader.onload = (e) => {
            profileImage.src = e.target.result;
          };
          reader.readAsDataURL(selectedFile);
          
        }
      });