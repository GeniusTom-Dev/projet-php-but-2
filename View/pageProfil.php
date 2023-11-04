<?php
require_once '../GFramework/autoloader.php';

$_GET['userProfile'] = 1;
$_SESSION['suid'] = 1;

$controller = new controlUserProfile($dbConn);

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Profil d'utilisateur</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body >
    <hr><br><strong>Profil d'utilisateur</strong><br><hr>


<div class="flex">
    <div class="min-h-screen flex-1 flex items-center justify-center bg-gray-200">
        <!-- Conteneur principal de la page -->
        <div class="article w-2/4 h-100 bg-gray-100 rounded-xl p-6 shadow-xl">
            <!-- En-tête de l'article (profil utilisateur) -->
            <?= $controller->getUserProfileInfo($_GET['userProfile']) ?>
              <!-- Section principale de l'article -->
            <main class="border-2 border-[#b2a5ff]-500 p-0.5 px-14 flex items-center justify-between flex-col">
              <h1 class="text-2xl font-semibold"><?php echo "Mes Postes"; ?></h1>
              <!-- Affiche les publications selon vos besoins -->
              <div class="flex items-center space-x-4">
                  <!-- Conteneur d'images -->
                  <div id="imageContainer" class="mt-4">
                      <!-- Input de type "file" caché pour télécharger des images -->
                      <input type="file" id="fileInput" accept="image/*" style="display: none;" class ="p-6">
                      <!-- Conteneur de galerie pour afficher les images ajoutées -->
                      <div id="galleryContainer" class="mt-4"></div>
                  </div>
              </div>
                  <!-- Bouton pour ajouter une image -->
                  <button id="plusButton" class="w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                      <!-- Image de bouton "plus" -->
                      <img src="/projet-php-but-2/html/images/plus-solid.svg" alt="plus">
                  </button>
              </div>
            </main>
        </div>
    </div>
</div>
<!-- Inclusion d'un fichier JavaScript pour gérer les fonctionnalités interactives -->
<script src="/projet-php-but-2/html/Script/script.js"></script>
    </body>
</html>