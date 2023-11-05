<?php
require "../GFramework/autoloader.php";

if (isset($_POST["deconnect"])){
    unset($_SESSION['suid']);
    unset($_SESSION['isAdmin']);
}

?>
<body id="theme-container">


  <nav class="flex left-0">
  
    <!-- Contenu principal de la page -->
    <?php
    if (isset($_SESSION['suid'])){
        $userData = $dbUsers->selectById($_SESSION['suid'])->getContent();
        $followers = $dbFollows->countFollower($_SESSION['suid']);
    }
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
            <?php if(isset($_SESSION['suid'])) { ?>
            <a href="pageProfil.php?userProfile=<?= $_SESSION['suid'] ?>">
                <img src="<?php if (empty($userData['USER_PROFIL_PIC'])){
                    echo '/projet-php-but-2/html/images/profile-removebg-preview.png'; // Default Profile Pic
                }
                else{
                    echo $userData['USER_PROFIL_PIC']; // User specific Profile Pic
                }?>" alt="Avatar" class="block w-100 h-100 rounded-full" id="ConnectedUserPic" width="200px" height="200px">
                <div class="absolute top-0 left-0 w-full h-full bg-black rounded-full bg-opacity-75 text-white text-center opacity-0 hover:opacity-100 transition-opacity">
                    <div class="flex items-center justify-center h-full">
                        <div class="text-2xl"><?= $userData['USERNAME'] ?></div>
                    </div>
                </div>
            </a>
            <?php } else { ?>
            <img src="/projet-php-but-2/html/images/profile-removebg-preview.png" alt="Avatar" class="block w-full rounded-full">
            <div class="absolute top-0 left-0 w-full h-full bg-black rounded-full bg-opacity-75 text-white text-center opacity-0 hover:opacity-100 transition-opacity">
                <div class="flex items-center justify-center h-full">
                    <div class="text-2xl">Invité</div>
                </div>
            </div>
            <?php } ?>


        </div>
        <!-- Affichage du nom d'utilisateur et du nombre d'abonnés -->
        <div class="info p-4 text-white text-center">
          <?php if(isset($_SESSION['suid'])) {
              echo $userData['USERNAME'];
              echo '<br>' . 'Followers ' . $followers;
          }
          else {
              echo 'Invité';
          } ?>
        </div>
        <!-- La liste du menu affiche les différentes sections -->
        <ul class="menu p-4 space-y-4 text-white text-center">
          <!-- Affiche si l'utilisateur est un admin -->
            <?php if (isset($_SESSION['suid']) && $_SESSION['isAdmin']){ ?>
                <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                    <a class="block h-full w-full" href="homeAdmin.php">Admin</a>
                </li>
            <?php } ?>
            <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                <a class="block h-full w-full" href="homepage.php">Accueil</a>
            </li>
            <?php if (isset($_SESSION['suid'])){ ?>
                <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                    <a class="block h-full w-full" href="pageProfil.php?userProfile=<?= $_SESSION['suid'] ?>">Profil</a>
                </li>
                <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                    <a class="block h-full w-full" href="creationPost.php">Nouveau Post</a>
                </li>
                <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                    <form method="post">
                        <button class="block h-full w-full" name="deconnect" value="1" onclick="submit()">Déconnexion</button>
                    </form>
                </li>
            <?php } else { ?>
                <li class="border border-gray-200 rounded-xl hover:bg-blue-200 hover:bg-blue-200 space-x-6 transition-bg transition-border" >
                    <a class="block h-full w-full" href="#" >Connexion</a> <!--href="login.php">-->
                </li>
            <?php } ?>
          <!-- Une boucle pour afficher les différentes sections à partir des tableaux tab et lien -->
            <li class="relative border border-gray-200 rounded-xl transition-bg transition-border">
                <a class="block h-full w-full cursor-pointer" id="categoryBtn">Catégories</a>
                <ul class="absolute left-0 w-44 max-h-full overflow-y-auto bg-[#b2a5ff] shadow-lg py-2 mt-2 space-y-2 text-black border border-gray-200 rounded-xl hidden" id="categoryDropdown">
                    <?php
                    foreach ($dbTopics->select_SQLResult(null, null, null, 'a-z')->getContent() as $topic) { ?>
                        <li class="px-6 hover:bg-blue-200 cursor-pointer"><?php echo $topic['NAME']; ?></li>
                    <?php }
                    ?>
                </ul>
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
  </nav>
</body>
  <script src="/projet-php-but-2/html/Script/navbar.js"></script>

