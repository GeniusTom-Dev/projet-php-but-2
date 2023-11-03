<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body id="theme-container" class="bg-blue-500">
  <div class="flex">

      <!-- Main content of the page -->
      <?php
/* tab : tableau avec les différente rubrique de la navbar*/
$tab = ["accueil","publication","profil","déconnexion"];
/*lien : tableau avec les liens vers les différentes pages*/
$lien = ["http://localhost/Projet/projet-php-but-2/index.php", "http://localhost/TpWeb/Tp2.php","http://localhost/TpWeb/calcul.php","http://localhost/Projet/projet-php-but-2/pageProfil.php","http://localhost/TpWeb/data-processing.php"];
/*name : Le nom de l'utilisateur*/ 
$name = "Zoro_13";
/*Follow représente le nombre de profil qui suivent l'utilisateur(lien avec la BD) */
$Follow = "320";

?>
<div id="menu-icon" class="text-white text-6xl cursor-pointer ml-6 ">
  &#9776; <!-- Caractère Unicode du burger icon -->
</div>

<div id="menu-container" class="w-3/10 h-screen rounded-xl shadow-2xl bg-green-500 hidden">
  <!-- Left-side menu content -->
  <div class="mx-auto  p-4">
  <div id="close-icon" class="text-white text-2xl cursor-pointer hidden">
  &#10006; <!-- Caractère Unicode de la croix (X) -->
</div>
  <div class="relative w-1/2 m-auto">
  <img src="/zoro.png" alt="Avatar" class="block w-full rounded-full">
  <div class="absolute top-0 left-0 w-full h-full bg-blue-500 rounded-full bg-opacity-75 text-white text-center opacity-0 hover:opacity-100 transition-opacity">
    <div class="flex items-center justify-center h-full">
      <div class="text-2xl">Zoro_13</div>
    </div>
  </div>
</div>
  <!-- Display the username and the number of followers -->
  <div class="info p-4 text-white text-center">
    <?php echo $name; ?><br>
    <?php echo  "Followers ". $Follow ; ?>
  
  <!-- The menu list displays the different sections -->
  <ul class="menu p-4 space-y-4 text-white ">
    <!-- A loop to display the different sections from the tab and links arrays -->
    <?php for ($i = 0; $i < count($tab); ++$i) : ?>
      <li class =" border border-gray-200 hover:bg-blue-200 hover:bg-blue-200 transition-bg transition-border ">
        <a href="<?php echo $lien[$i] ?>"><?php echo $tab[$i]; ?> </a>
      </li>
      <!-- Check if the current section is 'Catégorie' to display a dropdown -->
      <?php if ($i === 1) : ?>
        <li class="border border-gray-200 hover:bg-blue-200 hover:bg-blue-200 transition-bg transition-border ">
        <a href="#" class="dropbtn " id="categoryBtn">Catégorie</a>
        <div class="dropdown-content hidden absolute z-10 mt-2 space-y-2 py-2 flex flex-col" id="categoryDropdown">
            <!-- Links to different categories -->
            <a class="border border-gray-200 hover:bg-blue-200 hover:bg-blue-200 transition-bg transition-borderhref="http://localhost/dashboard">Link 1</a>
            <a class="border border-gray-200 hover:bg-blue-200 hover:bg-blue-200 transition-bg transition-borderhref="http://localhost/dashboard">Link 2</a>
            <a class="border border-gray-200 hover:bg-blue-200 hover:bg-blue-200 transition-bg transition-borderhref="http://localhost/dashboard">Link 3</a>
          </div>
        </li>
      <?php endif; ?>
    <?php endfor; ?>
    </div>
  </ul>
       <!-- Bouton de changement de thème -->
<div class="contenu text-center mt-4">
  <label id="switch" class="switch">
    <input type="checkbox" onchange="toggleTheme()" id="slider">
    <span class="custom-slider round">
    </span>
  </label>
</div>

    <div class="w-7/10">
  </div>
</div>
</div>
    </div>
  </div>

<script src="/Projet/projet-php-but-2/test.js"></script>

</body>
</html>
