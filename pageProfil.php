<?php
require_once 'initValues.php';

$userID = 1; // L'user dont on regarde la page de profil        // Pour Tester -> a remplacer plus tard par $_SESSION jsp quoi
$userIDConnected = 1; // L'user qui est connecté

$userData = $dbUsers->selectById($userID) ->getContent();

$name = $userData['USERNAME'];
$nbFollower = $dbFollows->countFollower($userID);
$nbFollowed = $dbFollows->countFollowed($userID);
$dernierConnexion = $userData['USER_LAST_CONNECTION'];
$userBio = $userData['USER_BIO'];


function start_page($title): void
{
?><!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?php echo $title; ?></title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body >
        <?php
        }

        start_page('Projet');
        function end_page($title): void
        {
        ?>
            <hr><br><strong><?php echo $title; ?></strong><br><hr>
        <?php
        }
?>
<div class="flex">
    <div class="min-h-screen flex-1 flex items-center justify-center bg-gray-200">
        <!-- Conteneur principal de la page -->
        <div class="article w-2/4 h-100 bg-gray-100 rounded-xl p-6 shadow-xl">
            <!-- En-tête de l'article (profil utilisateur) -->
            <header class="article-header relative mb-8">
               
            <!-- Image de profil utilisateur -->
            <div class="profile-picture" id="profilePicture">    
            <img src="/Projet/projet-php-but-2/html/images/profile-removebg-preview.png" alt="Photo de profil" id="profileImage"  class="article-image absolute top-0 left-8 w-40 h-40 rounded-full transition-transform hover:scale-125">
            </div>  
            <!-- Formulaire pour sélectionner un nouveau fichier de photo de profil -->
            <?php if ($userID == $userIDConnected) : ?>
                  <input type="file" id="fileInputPP" style="display: none" accept="image/*">
            <?php endif; ?>
                <!-- Informations de profil -->
                <div class="pl-64">
                    <p class="text-xl font-bold"><?php echo $name; ?></p>
                    <p class="mb-2"><?php echo "Follow ". $nbFollower ;?></p>
                    <p class="mb-2"><?php echo "Abonnement ".$nbFollowed; ?></p>
                    <p class="mb-2"><?php echo "Dernière connexion : ". $dernierConnexion; ?></p>
                    <!-- Section de la biographie et du formulaire de modification -->
                    <div class="bio" id="bioContainer">
                        <h1>Ma Biographie :</h1>
                        <p id="userBio">Aucune biographie</p>
                    </div>

                    <div class="bio-form" id="bioForm" style="display: none;">
                      <form id="editForm">
                          <textarea id="bioTextArea" rows="3" cols="20" placeholder="Saisissez votre biographie ici" maxlength="200"></textarea>
                          <p id="charCount">Caractères restants : 200</p>
                          <br>
                          <input type="submit" value="Enregistrer">
                      </form>
                    </div>
                    <?php if ($userID == $userIDConnected) : ?>
                  <!-- Bouton pour modifier la biographie -->
                  <button id="editButton">Modifier Ma Biographie</button>
                  <?php endif; ?> 
                </header>
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
                              <img src="/Projet/projet-php-but-2/html/images/plus-solid.svg" alt="plus">
                          </button>
                      </div>
                    </main>
            </div>
    </div>
</div>
<!-- Inclusion d'un fichier JavaScript pour gérer les fonctionnalités interactives -->
<script src="/Projet/projet-php-but-2/html/Script/script.js"></script>
    </body>
</html>