<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body id="theme-container" style="background-color: white;">
  <div class="flex">
  
    <!-- Contenu principal de la page -->
    <?php
    // Tableau des différentes rubriques de la navbar
    $tab = ["Accueil", "Publication", "Profil"];
    
    // Tableau des liens vers les différentes pages
    $lien = [
      "http://localhost/Projet/projet-php-but-2/index.php",
      "http://localhost/TpWeb/Tp2.php",
      "http://localhost/TpWeb/calcul.php",
    ];
    
    // Nom de l'utilisateur
    $name = "Zoro_13";
    
    // Nombre de profils qui suivent l'utilisateur (lien avec la BD)
    $Follow = "320";
    ?>
    
    <div id="menu-icon" class="text-6xl cursor-pointer ml-6" style="color: #b2a5ff">
      &#9776; <!-- Caractère Unicode de l'icône du menu (burger icon) -->
    </div>
    
    <div id="menu-container" class="w-3/10 h-screen rounded-xl shadow-2xl hidden" style="background-color: #b2a5ff;">
      <!-- Contenu du menu latéral gauche -->
      <div class="mx-auto  p-4">
        <div id="close-icon" class="text-2xl cursor-pointer hidden" style="color: #b2a5ff">
          &#10006; <!-- Caractère Unicode de l'icône de fermeture (X) -->
        </div>
        <div class="relative w-1/2 m-auto">
          <img src="/zoro.png" alt="Avatar" class="block w-full rounded-full">
          <div class="absolute top-0 left-0 w-full h-full bg-black rounded-full bg-opacity-75 text-white text-center opacity-0 hover:opacity-100 transition-opacity">
            <div class="flex items-center justify-center h-full">
              <div class="text-2xl"><?php echo $name; ?></div>
            </div>
          </div>
        </div>
        <!-- Affichage du nom d'utilisateur et du nombre d'abonnés -->
        <div class="info p-4 text-white text-center">
          <?php echo $name; ?><br>
          <?php echo  "Followers " . $Follow; ?>
        </div>
        <!-- La liste du menu affiche les différentes sections -->
        <ul class="menu p-4 space-y-4 text-white text-center">
          <!-- Affiche si l'utilisateur est un admin -->
        
          <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                <a class="block h-full w-full" href="#" >Admin</a>
          </li>
         
          <!-- Une boucle pour afficher les différentes sections à partir des tableaux tab et lien -->
          <?php for ($i = 0; $i < count($tab); ++$i) : ?>
            <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 transition-bg transition-border">
              <a class="block h-full w-full" href="<?php echo $lien[$i]; ?>"><?php echo $tab[$i]; ?></a>
            </li>
            <!-- Vérifiez si la section actuelle est 'Catégorie' pour afficher un menu déroulant -->
            <?php if ($i === 1) : ?>
              <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                <a href="#" class="dropbtn block h-full w-full" id="categoryBtn">Catégorie</a>
                <div class="dropdown-content border border-gray-200 hidden absolute z-64 mt-2 space-y-4 p-6 flex flex-col" style="background-color: #b2a5ff;" id="categoryDropdown">
                  <!-- Liens vers différentes catégories -->
                  <a class="border border-gray-200 rounded-xl hover:bg-blue-200 px-6 hover:bg-blue-200 transition-bg transition-border" href="http://localhost/dashboard">Link 1</a>
                  <a class="border border-gray-200 rounded-xl hover:bg-blue-200 px-6 hover:bg-blue-200 transition-bg transition-border" href="http://localhost/dashboard">Link 2</a>
                  <a class="border border-gray-200 rounded-xl hover.bg-blue-200 px-6 hover:bg-blue-200 transition-bg transition-border" href="http://localhost/dashboard">Link 3</a>
                </div>
              </li>
            <?php endif; ?>
          <?php endfor; ?>
          <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                <a class="block h-full w-full" id="connexion" href="#" >Déconnexion</a>
          </li>
        </ul>
        <!-- Bouton de changement de thème -->
        <div class="contenu text-center mt-4">
          <label id="switch" class="switch">
            <input type="checkbox" onchange="toggleTheme()" id="slider" value ="Thème">
          </label>
        </div>

      </div>
    </div>
  </div>

  <script src="/Projet/projet-php-but-2/navbar.js"></script>
</body>
</html>
