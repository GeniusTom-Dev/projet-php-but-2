// Récupérer l'élément de l'icône burger et le menu
const menuIconAdmin = document.getElementById('menuAdmin-icon');
const closeIconAdmin = document.getElementById('close-icon');
const menuAdminContainer = document.getElementById('menuAdmin-container');

// Ajouter un écouteur d'événements pour le clic sur l'icône burger
menuIconAdmin.addEventListener('click', () => {
    menuAdminContainer.classList.remove('hidden'); // Affiche le menu
    closeIconAdmin.classList.remove('hidden'); // Affiche l'icône de fermeture
    menuIconAdmin.classList.add('hidden'); // Masque l'icône burger
  });
  
// Ajouter un écouteur d'événements pour le clic sur l'icône de fermeture
closeIconAdmin.addEventListener('click', () => {
  menuAdminContainer.classList.add('hidden'); // Masque le menu
  closeIconAdmin.classList.add('hidden'); // Masque l'icône de fermeture
  menuIconAdmin.classList.remove('hidden'); // Affiche l'icône burger
});