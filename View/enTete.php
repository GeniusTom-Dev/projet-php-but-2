<?php
require "../GFramework/autoloader.php";

if (isset($_POST["deconnect"])){
    unset($_SESSION['suid']);
    unset($_SESSION['isAdmin']);
}  
    if (isset($_SESSION['suid'])){
        $userData = $dbUsers->selectById($_SESSION['suid'])->getContent();
        $followers = $dbFollows->countFollower($_SESSION['suid']);
    }
    ?>
<header class="flex flex-lign items-center mb-2 bg-purple-800 p-2">
    <div class="w-100 h-100">
    <?php if(isset($_SESSION['suid'])) { ?>
                <img src="<?php if (empty($userData['USER_PROFIL_PIC'])){
                    echo '/projet-php-but-2/html/images/profile-removebg-preview.png'; // Default Profile Pic
                }
                else{
                    echo $userData['USER_PROFIL_PIC']; // User specific Profile Pic
                }?>" alt="Avatar" class="w-20 h-auto rounded-full transition-transform duration-300 hover:scale-125 mr-1" id="ConnectedUserPic" >
            <?php } else { ?>
            <img src="/projet-php-but-2/html/images/profile-removebg-preview.png" alt="Avatar" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
            <?php } ?>    
    </div>
    <div class="flex justify-center items-center ml-16">
        <?php include '../GFramework/searchBar/searchBar.php' ?>
    </div>
</header>
