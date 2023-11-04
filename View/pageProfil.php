<?php
require_once '../GFramework/autoloader.php';

$_GET['userProfile'] = 1;
$_SESSION['suid'] = 1;
$_SESSION['isAdmin'] = true;

//
$controllerProfile = new controlUserProfile($dbConn);
$controllerProfile->checkNewBio();
$controllerProfile->postController->checkAllShowActions();

$controllerCreatePost = new controlCreatePosts($dbConn);
$controllerCreatePost->checkCreatePost();

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
            <?= $controllerProfile->getUserProfileInfo($_GET['userProfile']) ?>
              <!-- Section principale de l'article -->
            <main class="border-2 border-[#b2a5ff]-500 p-0.5 px-14 flex items-center justify-between flex-col">
                <section>
                    <h1 class="text-2xl font-semibold">Posts</h1>
                    <!-- Affiche l'interface de publication de post -->
                    <div class="flex items-center space-x-4">
                        <?php if (isset($_SESSION['suid']) && $_SESSION['suid'] == $_GET['userProfile']){
                            echo $controllerCreatePost->getCreatePost(); ?>
                        <script src="/projet-php-but-2/html/Script/scriptCreatePost.js"></script>
                        <?php } ?>
                        <button id="plusButton" class="showCreationPostButton w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                            <!-- Image de bouton "plus" -->
                            <img src="/projet-php-but-2/html/images/plus-solid.svg" alt="plus">
                        </button>
                    </div>
                    <!-- Affiche les publications selon vos besoins -->
                    <div>
                        <?= $controllerProfile->getUserPosts($_GET['userProfile'], 15, 'recent') ?>
                        <script src="/projet-php-but-2/html/Script/scriptShowPost.js"></script>
                    </div>
                </section>
                <?php if (isset($_SESSION['suid']) && $_SESSION['suid'] == $_GET['userProfile']){ ?>
                    <section>
                        <h1 class="text-2xl font-semibold">Favoris</h1>
                        <!-- Affiche les publications selon vos besoins -->
                        <div>
                            <?= $controllerProfile->getUserBookmarks($_GET['userProfile'], 15, 'recent') ?>
                        </div>
                    </section>
                <?php } ?>

            </main>
        </div>
    </div>
</div>
<!-- Inclusion d'un fichier JavaScript pour gérer les fonctionnalités interactives -->
<script src="/projet-php-but-2/html/Script/script.js"></script>
    </body>
</html>