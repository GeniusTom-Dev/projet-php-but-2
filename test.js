// Récupérer l'élément "Catégorie" et le menu déroulant
const categoryBtn = document.getElementById('categoryBtn');
const categoryDropdown = document.getElementById('categoryDropdown');
const slider = document.getElementById('slider');
const themeContainer = document.getElementById('theme-container');
const menuContainer = document.getElementById('menu-container');
// Récupérer l'élément de l'icône burger et le menu
const menuIcon = document.getElementById('menu-icon');
const closeIcon = document.getElementById('close-icon');

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
    themeContainer.classList.remove('bg-blue-500');
    themeContainer.classList.add('bg-red-500');
    // Changer les classes de texte en fonction du thème
    const textElements = document.querySelectorAll('.text-green');
    textElements.forEach((element) => {
      element.classList.replace('text-green', 'text-yellow');
    });
  } else {
    // Appliquer le thème bleu
    themeContainer.classList.remove('bg-red-500');
    themeContainer.classList.add('bg-blue-500');
    // Changer les classes de texte en fonction du thème
    const textElements = document.querySelectorAll('.text-yellow');
    textElements.forEach((element) => {
      element.classList.replace('text-yellow', 'text-green');
    });
  }
  if (slider.checked) {
    // Appliquer le thème jaune
    menuContainer.classList.remove('bg-green-500');
    menuContainer.classList.add('bg-yellow-500');
    // Appliquer la couleur de fond jaune au menu déroulant
        link.classList.remove('bg-green-500', 'hover:bg-green-600');
        link.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
  }else {
    // Appliquer le thème vert
    menuContainer.classList.remove('bg-yellow-500');
    menuContainer.classList.add('bg-green-500');
    // Appliquer la couleur de fond verte au menu déroulant
    
        link.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
        link.classList.add('bg-green-500', 'hover:bg-green-600');
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