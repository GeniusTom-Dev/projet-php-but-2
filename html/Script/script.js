let postCreatorInterface = document.querySelector(".postCreationInterface");
postCreatorInterface.style.display = "none";

// Variable pour suivre l'état actuel de l'agrandissement
let plusButtonCreation = document.querySelector(".showCreationPostButton");

const profilePicture = document.getElementById("profilePicture");
let fileInputPP = document.querySelector("#fileInputPP");

// Variable bouton supprimer, et biographie
// let trashCan = document.querySelector("#trashCan");
const bioContainer = document.getElementById("bioContainer");
    const bioForm = document.getElementById("bioForm");
    const userBio = document.getElementById("userBio");
    const editButton = document.getElementById("editButton");
    const editForm = document.getElementById("editForm");
    const bioTextArea = document.getElementById("bioTextArea");


plusButtonCreation.addEventListener("click", (e) => {

    if (postCreatorInterface.style.display === "none"){
        postCreatorInterface.style.display = "block";
    }
    else{
        postCreatorInterface.style.display = "none";
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
    const maxLength = bioTextArea.maxLength;
    const currentLength = bioTextArea.value.length;

    if (currentLength > maxLength) {
        alert('La biographie dépasse la limite de caractères autorisée.');
        event.preventDefault(); // Empêcher la soumission du formulaire
    }
    else{
        // alert('La biographie respecte la norme');
        // editForm.submit();
    }

  });

   // Gérer le clic sur la photo de profil pour ouvrir le sélecteur de fichier
profilePicture.addEventListener("click", () => {
    if (fileInputPP != null){
        fileInputPP.click();
    }
});

if (fileInputPP != null) {
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
}