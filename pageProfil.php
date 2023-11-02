<?php
// Inclusion du fichier "utils.inc.php" contenant les fonctions/utilitaires nécessaires
require 'utils.inc.php';
?>

<div class="flex">
    <div class="min-h-screen flex-1 flex items-center justify-center bg-gray-200">
        <!-- Conteneur principal de la page -->
        <div class="article w-2/4 h-100 bg-gray-100 rounded-xl p-6 shadow-xl">
            <!-- En-tête de l'article (profil utilisateur) -->
            <header class="article-header relative mb-8">
                <!-- Image de profil utilisateur -->
                <img src="/zoro.png" alt="PP" class="article-image absolute top-0 left-8 w-40 h-40 rounded-full transition-transform hover:scale-125">
                <!-- Informations de profil -->
                <div class="pl-64">
                    <p class="text-xl font-bold"><?php echo "Zoro_13"; ?></p>
                    <p class="mb-2"><?php echo "Follow | 320 followers"; ?></p>
                    <p class="mb-2"><?php echo "Abonnements : 800"; ?></p>
                    <p class="mb-2"><?php echo "Dernière connexion : ..."; ?></p>
                    <p class="mb-2"><?php echo "Bio : La bio de mon profil"; ?></p>
                </div>
            </header>
            <!-- Section principale de l'article -->
            <main class="border-2 border-[#b2a5ff]-500 p-0.5 px-14 flex items-center justify-between flex-col">
                <h1 class="text-2xl font-semibold"><?php echo "Mes Postes"; ?></h1>
                <!-- Affiche les publications selon vos besoins -->
                <div class="flex items-center space-x-4">
                    <!-- Conteneur d'images -->
                    <div id="imageContainer" class="mt-4">
                        <!-- Bouton pour ajouter une image -->
                        <button id="plusButton" class="w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                            <!-- Image de bouton "plus" -->
                            <img src="/Projet/projet-php-but-2/html/images/plus-solid.svg" alt="plus">
                        </button>
                        <!-- Input de type "file" caché pour télécharger des images -->
                        <input type="file" id="fileInput" accept="image/*" style="display: none;" class ="p-6">
                        <!-- Conteneur de galerie pour afficher les images ajoutées -->
                        <div id="galleryContainer" class="mt-4"></div>
                    </div>
                </div>
                <!-- Section vide pour afficher les images sélectionnées -->
                <div class="py-8">
                    <div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<!-- Inclusion d'un fichier JavaScript pour gérer les fonctionnalités interactives -->
<script src="/Projet/projet-php-but-2/html/Script/script.js"></script>