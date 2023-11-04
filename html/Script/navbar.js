// Récupérer l'élément "Catégorie" et le menu déroulant
const categoryBtn = document.getElementById('categoryBtn');
const categoryDropdown = document.getElementById('categoryDropdown');
const slider = document.getElementById('slider');
const themeContainer = document.getElementById('theme-container');
const menuContainer = document.getElementById('menu-container');
// Récupérer l'élément de l'icône burger et le menu
const menuIcon = document.getElementById('menu-icon');
const closeIcon = document.getElementById('close-icon');

let connexion = document.querySelector("#connexion");
// Variable pour suivre l'état actuel de l'abonnement
let isLogIn = false;

  // Ajouter un écouteur d'événements pour le clic sur "Catégorie"
  categoryBtn.addEventListener('click', () => {
    categoryDropdown.classList.toggle('hidden');
  });

  // Ajouter un écouteur d'événements pour masquer le menu déroulant lorsqu'on clique ailleurs
  document.addEventListener('click', (event) => {
    if (event.target !== categoryBtn) {
      categoryDropdown.classList.add('hidden');
    }
  });

  // Empêcher la propagation du clic à l'intérieur du menu déroulant
  categoryDropdown.addEventListener('click', (event) => {
    event.stopPropagation();
  });

  // Fonction pour changer de thème
function toggleTheme() {
  const slider = document.getElementById('slider');
  const body = document.body;

  if (slider.checked) {
    // Appliquer le thème rouge
    themeContainer.style.backgroundColor = "#b2a5ff";
    // Appliquer le thème jaune menu
    menuContainer.style.backgroundColor = "black";
    menuIcon.style.color ="black";
    closeIcon.style.color ="#b2a5ff";
    
    // Changer les classes de texte en fonction du thème
    const textElements = document.querySelectorAll('.text-green');
    textElements.forEach((element) => {
      element.classList.replace('text-green', 'text-yellow');
    });
  } else {
    // Appliquer le thème bleu
    themeContainer.style.backgroundColor = "white";
    // Appliquer le thème vert au menu
    menuContainer.style.backgroundColor = "#b2a5ff";
    menuIcon.style.color ="#b2a5ff";
    closeIcon.style.color ="black";
    // Changer les classes de texte en fonction du thème
    const textElements = document.querySelectorAll('.text-yellow');
    textElements.forEach((element) => {
      element.classList.replace('text-yellow', 'text-green');
    });
  }
}

// Ajouter un écouteur d'événements pour le clic sur l'icône burger
menuIcon.addEventListener('click', () => {
    menuContainer.classList.remove('hidden'); // Affiche le menu
    closeIcon.classList.remove('hidden'); // Affiche l'icône de fermeture
    menuIcon.classList.add('hidden'); // Masque l'icône burger
  });
  
  // Ajouter un écouteur d'événements pour le clic sur l'icône de fermeture
  closeIcon.addEventListener('click', () => {
    menuContainer.classList.add('hidden'); // Masque le menu
    closeIcon.classList.add('hidden'); // Masque l'icône de fermeture
    menuIcon.classList.remove('hidden'); // Affiche l'icône burger
  });
  //S'abonner ou se désabonner
  connexion.addEventListener("click", () => {
  if (!isLogIn) {
      // Si l'utilisateur n'est pas encore abonné
      connexion.textContent = "Connexion"; // Change le texte du bouton
  } else {
      // Si l'utilisateur est déjà abonné et clique pour se désabonner
      connexion.textContent = "Déconnexion"; // Rétablit le texte d'origine
  }

  // Inverse l'état de l'abonnement
  isLogIn= !isLogIn;
});
 