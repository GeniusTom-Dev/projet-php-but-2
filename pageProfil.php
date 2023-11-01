<?php
    require 'utils.inc.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-200">
    <div class="article w-2/5 h-100 bg-gray-100 rounded-xl p-8 shadow-xl transition-transform hover:scale-105">
        <header class="article-header relative mb-14 ">
            <img src="/zoro.png" alt="PP" class="article-image absolute top-0 left-8 w-32 h-32 rounded-full transition-transform hover:scale-125">
            <div class="pl-64">
                <p class="text-xl font-bold"><?php echo "Zoro_13"; ?></p>
                <p class="mb-2"><?php echo "Follow | 320 followers"; ?></p>
                <p class="mb-2"><?php echo "Dernière connexion ; ..."; ?></p>
                <p class="mb-2"><?php echo "Bio : testetest"; ?></p>
            </div>
        </header>
        <main class="border-2 border-cyan-500 p-0.5 px-14 flex items-center justify-center flex-col">
            <h1 class="text-2xl font-semibold"><?php echo "Titre poste"; ?></h1>
            <p class="text-gray-700">Ceci est un exemple de post Twitter-like.</p>
            <p class="text-gray-700">Vous pouvez ajouter plus de contenu ici.</p>
            <img src="/Poste.jpeg" alt="PP" class="article-image top-0 left-20 w-56 h-56 ">
            
        </main>
        <div id="deleteConfirmation" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md" style="display: none;">
            <p>Voulez-vous vraiment supprimer cet élément ?</p>
            <button id="confirmDeleteButton" class="px-4 py-2 bg-red-500 text-white rounded-md ml-2">Confirmer</button>
            <button id="cancelDeleteButton" class="px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
        </div>
        <footer class="mt-4 text-center">
            <p class="text-gray-700">Tags : <a href="#" class="text-blue-500">Tag1</a>, <a href="#" class="text-blue-500">Tag2</a>, <a href="#" class="text-blue-500">Tag3</a></p>
        </footer>
    </div>
</div>

