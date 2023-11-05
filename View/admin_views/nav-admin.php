
<nav >
<div id="menuAdmin-icon" class="text-6xl cursor-pointer ml-6" style="color: #b2a5ff">
      &#9776; <!-- Caractère Unicode de l'icône du menu (burger icon) -->
</div>   
<div id="menuAdmin-container" class="rounded-xl shadow-2xl p-4 relative p-4 text-white text-center hidden" style="background-color: #b2a5ff;">
<div id="close-icon" class="text-2xl cursor-pointer flex items-start mb-2 hidden" >
          &#10006; <!-- Caractère Unicode de l'icône de fermeture (X) -->
</div>
<form class="mb-4 border border-gray-200 rounded-xl hover:bg-blue-200 space-x-6 transition-bg transition-border" action="homepage.php">
        <button class="block h-full w-full" onclick="submit()">Quitter mode admin.</button>
    </form>
    <form  method="get">
        <ul>
            <li class="mb-4 border border-gray-200 rounded-xl hover:bg-blue-200 space-x-6 transition-bg transition-border">
                <button class="block h-full w-full" name="tab" id="categories" value="categories" onclick="submit()">Catégories</button>
            </li>
            <li class="mb-4 border border-gray-200 rounded-xl hover:bg-blue-200 space-x-6 transition-bg transition-border">
                <button class="block h-full w-full" name="tab" id="utilisateurs" value="utilisateurs" onclick="submit()">Utilisateurs</button>
            </li>
            <li class="mb-4 border border-gray-200 rounded-xl hover:bg-blue-200 space-x-6 transition-bg transition-border">
                <button class="block h-full w-full" name="tab" id="posts" value="posts" onclick="submit()">Posts / Billets</button>
            </li>
            <li class="mb-4 border border-gray-200 rounded-xl hover:bg-blue-200 space-x-6 transition-bg transition-border">
                <button class="block h-full w-full" name="tab" id="commentaires" value="commentaires" onclick="submit()">Commentaires</button>
            </li>
        </ul>
    </form>
</div>
</nav>
<script src="/projet-php-but-2/html/Script/navbarAdmin.js"></script>
