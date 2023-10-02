<!DOCTYPE html>
<html>
<head>
    <title>Ma Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/html/styles/index.css">

</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-blue-500 h-screen w-64 fixed left-0"></div>

<article class="w-1/2 h-1/3 bg-gray-100 rounded-lg shadow-md p-6 transition-transform duration-300 hover:scale-105 article">
    <header class="flex justify-between items-center mb-16">
        <img src="/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125">
        <div class="flex flex-col">
            <p>@Profile_name</p>
            <p>Follow | 1K followers</p>
        </div>
        <img id="growArrow" src="/html/images/fleches.svg" alt="growArrow" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    </header>
    <main>
        <h1>Titre poste</h1>
        <p>Ceci est un exemple de post Twitter-like.</p>
        <p>Vous pouvez ajouter plus de contenu ici.</p>
    </main>
    <footer>
        <!--class="prose bg-gray-100 rounded-lg shadow-md p-4 max-h-40 overflow-y-auto"-->
        <div id="comment-section" class="p-4 max-h-40 overflow-y-auto">
            <h2 class="mb-4">Commentaires</h2>
            <!-- Les commentaires seront affichés ici -->
            <div id="comments-container" class="max-h-40 overflow-y-auto"></div>
            <div class="flex items-center mb-2"> <!-- Conteneur pour les boutons -->
                <textarea id="comment-input" placeholder="Ajoutez un commentaire..." class="w-full p-2 border border-gray-300 rounded-md"></textarea>
                <button id="comment-button" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md cursor-pointer">Poster</button>
            </div>
        </div>
    </footer>
</article>

<div class="absolute left-1/2 transform -translate-x-1/2 bottom-10 w-1/2 flex justify-between items-center p-2">
    <img id="arrowLeft" src="/html/images/arrow-left-solid.svg" alt="arrowLeft" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="heartRegular" src="/html/images/heart-regular.svg" alt="heart" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="bookmarkRegular" src="/html/images/bookmark-regular.svg" alt="bookmark" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="arrowRight" src="/html/images/arrow-right-solid.svg" alt="arrowRight" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
</div>

<!-- Incluez le script JavaScript après les éléments HTML qu'il utilise -->
<script src="/html/script/script.js"></script>
</body>
</html>
