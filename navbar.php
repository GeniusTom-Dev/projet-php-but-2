<?php
    require 'utils.inc.php'
?>
<!--header -->
<header class ="navbarheader">

<?php
/* tab : tableau avec les différente rubrique de la navbar*/
$tab = ["accueil","story","publication","profil","déconnexion"];
/*lien : tableau avec les liens vers les différentes pages*/
$lien = ["http://localhost/Projet/projet-php-but-2/index.php", "http://localhost/TpWeb/Tp2.php","http://localhost/TpWeb/calcul.php","http://localhost/Projet/projet-php-but-2/pageProfil.php","http://localhost/TpWeb/data-processing.php"];
/*name : Le nom de l'utilisateur*/ 
$name = "Zoro_13";
/*Follow représente le nombre de profil qui suivent l'utilisateur(lien avec la BD) */
$Follow = "320";

?>
<!--La balise de la navbar -->
  <nav>
    
  <div class="container">
    <!--Class image qui affiche la photo de porfil de l'utilisateur -->
    <img src="/zoro.png" alt="Avatar" class="image">
    <!--La classe overlay permet d'afficher le nom d'utilisateur au survole de l'image-->
    <div class="overlay">
      <!-- La classe text affiche le nom d'utilisateur dans l'overlay-->
      <div class="text">Zoro_13</div>
    </div>
  </div>
    <!--Affiche le nom et le nombre de followers -->
    <div class = "info">
      <?php echo $name ;?><br>
      <?php echo $Follow." Followers" ;?>

      </div>
      <!-- La liste menu affiche les différente rubrique -->
      <ul class = "menu"> 
          <!--Un boucle  permettant d'afficher les différentes rubrique du tableau tab et de lien -->
          <?php
          for ($i = 0 ; $i<count($tab);++$i) {
            
        ?>  
                  <li>
                      <a href="<?php echo $lien[$i]?>"><?php echo $tab[$i];?> </a>
                  </li>
          <?php
          /*Condition qui vérifie que la tab[i] vaut la valeur de tab[0]catégorie*/
          if($tab[$i] === $tab[0]){
            ?>
            <!-- La classe dropdown : permet de dérouler un sous-menu de catégorie-->
            <li class="dropdown">
              <!--La classe dropbtn : est la rubrique qui déroulera le sous-menu-->
              <a href="Catégorie" class="dropbtn">Catégorie</a>
              <!--dropdown-content : est le contenu du sous-menu -->
              <div class="dropdown-content">
                <!--lien vers les différentes catégorie -->
                <a href="http://localhost/dashboard">Link 1</a>
                <a href="http://localhost/dashboard">Link 2</a>
                <a href="http://localhost/dashboard">Link 3</a>
              </div>
            </li>
            
            <?php
            }
          }
          ?>
      </ul>
      <div class="contenu">
      <label id="switch" class="switch">
        <input type="checkbox" onchange="toggleTheme()" id="slider">
        <span class="slider round"></span>
    </label>
        </div>
  </nav>
</header>
<script>
      // function to set a given theme/color-scheme
      function setTheme(themeName) {
            localStorage.setItem('theme', themeName);
            document.documentElement.className = themeName;
        }

        // function to toggle between light and dark theme
        function toggleTheme() {
            if (localStorage.getItem('theme') === 'theme-dark') {
                setTheme('theme-light');
            } else {
                setTheme('theme-dark');
            }
        }

        // Immediately invoked function to set the theme on initial load
        (function () {
            if (localStorage.getItem('theme') === 'theme-dark') {
                setTheme('theme-dark');
            } else {
                setTheme('theme-light');
            }
        })();
</script>





