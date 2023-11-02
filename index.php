<!DOCTYPE html>
<html>
<head>
    <title>Ma Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="/html/styles/index.css">

</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-[#b2a5ff] h-screen w-64 fixed left-0"></div>

<article id="article" class="w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
    <header class="flex justify-between items-center mb-16">
        <img src="/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125">
        <div class="flex flex-col">
            <p>@Profile_name</p>
            <p>Follow | 1K followers</p>
        </div>
        <button id="suscribe-button" class="ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md">S'abonner</button>
        <img id="growArrow" src="/html/images/fleches.svg" alt="growArrow" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    </header>
    <main class="max-h-60 overflow-y-auto">
        <div class="flex flex-lign items-center mb-2">
            <h1 class="mr-2">Titre poste</h1>
            <img id="trashCan" src="/html/images/trash-can-solid.svg" alt="trashCan" class="w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
        </div>
        <p>Ceci est un exemple de post Twitter-like.</p>
        <p>Vous pouvez ajouter plus de contenu ici.</p>
        <div id="imageContainer" class="mt-4">
            <button id="plusButton" class="w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                <img src="/html/images/plus-solid.svg" alt="plus">
            </button>
            <!-- Input de type "file" caché -->
            <input type="file" id="fileInput" accept="image/*" style="display: none;">
        </div>
        <div id="galleryContainer" class="mt-4"></div>
        <input type="text" id="category-input" placeholder="Nouvelle catégorie" class="border border-[#b2a5ff] rounded-md">
        <button id="add-category-button" class="bg-[#b2a5ff] text-white rounded-md px-2 py-1 m-2">Ajouter Catégorie</button>
        <ul class="category-list" id="category-list"></ul>
    </main>
    <footer>
        <div id="comment-section" class="p-4 max-h-40 overflow-y-auto">
            <h2 class="mb-4">Commentaires</h2>
            <div id="comments-container" class="max-h-40 overflow-y-auto"></div>
            <div class="flex items-center mb-2">
                <textarea id="comment-input" placeholder="Ajoutez un commentaire..." class="w-full p-2 border border-[#b2a5ff] rounded-md"></textarea>
                <button id="comment-button" class="ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md">Poster</button>
            </div>
        </div>
        <img id="paperPlane" src="/html/images/paper-plane-solid.svg" alt="paperPlane" class="w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
    </footer>
</article>

<div class="absolute left-1/2 transform -translate-x-1/2 bottom-10 w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto flex justify-between items-center p-2">
    <img id="arrowLeft" src="/html/images/arrow-left-solid.svg" alt="arrowLeft" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="heartRegular" src="/html/images/heart-regular.svg" alt="heart" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="bookmarkRegular" src="/html/images/bookmark-regular.svg" alt="bookmark" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="arrowRight" src="/html/images/arrow-right-solid.svg" alt="arrowRight" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
</div>

<div id="deleteConfirmation" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md" style="display: none;">
    <p>Voulez-vous vraiment supprimer cet élément ?</p>
    <button id="confirmDeleteButton" class="px-4 py-2 bg-red-500 text-white rounded-md ml-2">Confirmer</button>
    <button id="cancelDeleteButton" class="px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
</div>

<script src="/html/script/script.js"></script>
</body>
</html>
