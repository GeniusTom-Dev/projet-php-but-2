<!DOCTYPE html>
<html>
<head>
    <title>Ma Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-blue-500 h-screen w-64 fixed left-0"></div>

<article class="w-96 h-96 bg-gray-100 rounded-lg shadow-md p-6 transition-transform duration-300 hover:scale-105">
    <header class="relative mb-16">
        <p class="absolute top-0 left-0 ml-4 mt-4">@Profile_name</p>
        <p class="ml-4">Follow | 1K followers</p>
        <img id="growArrow" src="/html/images/fleches.svg" alt="growArrow" class="absolute top-0 right-0 w-8 h-auto transition-transform duration-300 hover:scale-125">
        <img src="/html/images/profile-removebg-preview.png" alt="PP" class="absolute top-0 left-0 w-20 h-auto transition-transform duration-300 hover:scale-125">
    </header>
    <main>
        <h1>Titre poste</h1>
        <p>Ceci est un exemple de post Twitter-like.</p>
        <p>Vous pouvez ajouter plus de contenu ici.</p>
    </main>
    <footer>
        <div id="comment-section" class="bg-gray-100 rounded-lg shadow-md p-4 max-h-40 overflow-y-auto">
            <h2 class="mb-4">Commentaires</h2>
            <!-- Les commentaires seront affichés ici -->
            <textarea id="comment-input" placeholder="Ajoutez un commentaire..." class="w-full p-2 border border-gray-300 rounded-md"></textarea>
            <button id="comment-button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md cursor-pointer">Poster</button>
        </div>
    </footer>
</article>

<div class="absolute left-1/2 transform -translate-x-1/2 bottom-10 w-1/2 flex justify-between items-center p-2">
    <img id="arrowLeft" src="/html/images/arrow-left-solid.svg" alt="arrowLeft" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="heartRegular" src="/html/images/heart-regular.svg" alt="heart" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="bookmarkRegular" src="/html/images/bookmark-regular.svg" alt="bookmark" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
    <img id="arrowRight" src="/html/images/arrow-right-solid.svg" alt="arrowRight" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
</div>

<script src="/html/script/script.js"></script>
</body>
</html>
