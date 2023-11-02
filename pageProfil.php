<?php
require 'utils.inc.php';
?>

<div class="flex">
    <!-- <div class="bg-[#b2a5ff] h-screen w-64 fixed left-0"></div>-->
    <div class="min-h-screen flex-1 flex items-center justify-center bg-gray-200">
        <div class="article w-2/4 h-100 bg-gray-100 rounded-xl p-6 shadow-xl">
            <header class="article-header relative mb-8">
                <img src="/zoro.png" alt="PP" class="article-image absolute top-0 left-8 w-40 h-40 rounded-full transition-transform hover:scale-125">
                <!-- Informations de profil -->
                <div class="pl-64">
                    <p class="text-xl font-bold"><?php echo "Zoro_13"; ?></p>
                    <p class="mb-2"><?php echo "Follow | 320 followers"; ?></p>
                    <p class="mb-2"><?php echo "Abonnements : 800"; ?></p>
                    <p class="mb-2"><?php echo "Dernière connexion : ..."; ?></p>
                    <p class="mb-2"><?php echo "Bio : testetest"; ?></p>
                </div>
            </header>
            <main class="border-2 border-[#b2a5ff]-500 p-0.5 px-14 flex items-center justify-between flex-col">
                <h1 class="text-2xl font-semibold"><?php echo "Mes Poste"; ?></h1>
                <p class="text-gray-700">Ceci est un exemple de post Twitter-like.</p>
                <p class="text-gray-700">Vous pouvez ajouter plus de contenu ici.</p>
                <!-- Affiche les publications selon vos besoins -->
                <div class="flex items-center space-x-4">
                    <div id="imageContainer" class="mt-4">
                        <button id="plusButton" class="w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                            <img src="/Projet/projet-php-but-2/html/images/plus-solid.svg" alt="plus">
                        </button>
                        <!-- Input de type "file" caché -->
                        <input type="file" id="fileInput" accept="image/*" style="display: none;" class ="p-6">
                        <div id="galleryContainer" class="mt-4"></div>
                    </div>
                </div>
                <div class="py-8">
                    <div>
                        <!--Affiche image si elle est sélectionnée-->
                        <?php
                        if ($selectedImage) {
                        ?>
                        <div class="mx-auto max-w-2xl h-auto rounded-lg p-2">
                            <img src="<?php echo $selectedImage; ?>" alt="Image Sélectionnée" class="w-56 h-auto">
                        </div>
                        <img id="trashCan" src="/Projet/projet-php-but-2/html/images/trash-can-solid.svg" alt="trashCan" class="w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                        <?php
                        } else {
                        ?>
                        <p class="text-lg">Aucune image sélectionnée.</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<script src="/Projet/projet-php-but-2/html/Script/script.js"></script>