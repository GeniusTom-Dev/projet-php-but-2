<?php
session_start();
require_once '../GFramework/autoloader.php';

$_GET['userProfile'] = 2;
$_SESSION['suid'] = 2;
$_SESSION['isAdmin'] = true;

// Restore selected userProfile or save
if (isset($_GET['userProfile'])) {
    $_SESSION['userProfile'] = $_GET['userProfile'];
}
else {
    if (!isset($_SESSION['userProfile'])){
        header('Location: homepage.php');
        die();
    }
    $_GET['userProfile'] = $_SESSION['userProfile'];
}

$controllerProfile = new controlUserProfile($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
$controllerProfile->checkNewBio();
$controllerProfile->checkNewProfilePic();
$controllerProfile->postController->checkAllShowActions();

$controllerCreatePost = new controlCreatePosts($dbConn);
$controllerCreatePost->checkCreatePost();

require_once '../GFramework/utilities/utils.inc.php';
start_page("Profil Utilisateur");

require_once "enTete.php";
?>
<div class=" h-screen w-64 fixed left-0">
    <?php require_once "navbarTailswind.php";?>
</div>

<div class="flex">
    <div class="min-h-screen flex-1 flex items-center justify-center ">
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
                        <?= $controllerProfile->getUserPosts($_GET['userProfile'], 10, 'recent') ?>
                        <script src="/projet-php-but-2/html/Script/scriptShowPost.js"></script>
                    </div>
                </section>
                <?php if (isset($_SESSION['suid']) && $_SESSION['suid'] == $_GET['userProfile']){ ?>
                    <section>
                        <h1 class="text-2xl font-semibold">Favoris</h1>
                        <!-- Affiche les publications selon vos besoins -->
                        <div>
                            <?= $controllerProfile->getUserBookmarks($_GET['userProfile'], 10, 'recent') ?>
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