<?php

namespace controllers;
use controlGeneratePosts;
use DbFavorites;
use DbFollows;
use DbPosts;
use DbUsers;

class controlUser
{

    private DbUsers $dbUsers;
    private DbFollows $dbFollows;

    public function __construct($conn)
    {
        $this->dbFollows = new DbFollows($conn);
        $this->dbUsers = new DbUsers($conn);
    }

    public function getUserProfileSimple(int $userID): string
    {
        $userData = $this->dbUsers->selectById($userID)->getContent();
        ob_start(); ?>
        <section class="userProfileSimple flex flex-lign items-center mb-2">
            <form action="userProfile.php" method="get"> <!-- Affichage page profil utilisateur -->
                <input type="hidden" name="userProfile" value="<?= $userData['USER_ID'] ?>">
                    <div class="w-100 h-100">
                        <img src="<?php if (empty($userData['USER_PROFIL_PIC'])){
                            echo '/projet-php-but-2/html/images/profile-removebg-preview.png';
                        }
                        else{
                            echo $userData['USER_PROFIL_PIC'];
                        }
                        ?>" alt="Photo de profil" id="profileImage" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
                    </div>
            </form>
            <div class="flex flex-col mr-1">
                <p>@<?= $userData['USERNAME'] ?></p>
                <p>Follow | <?= $this->dbFollows->countFollower($userID) ?> followers</p>
            </div>
            <form method="post">
                <?php if (isset($_SESSION['suid']) && $userID != $_SESSION['suid']) { if ($this->dbFollows->doesUserFollowAnotherUser($_SESSION['suid'], $userID)){ ?>
                    <button class="suscribe-button ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md" onclick="submit()" name="unsubscribe" value="<?= $userID ?>">Se désabonner</button>
                <?php } else {?>
                    <button class="suscribe-button ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md" onclick="submit()" name="subscribe" value="<?= $userID ?>">S'abonner</button>
                <?php }} ?>
            </form>
        </section>


        <?php $userHeader = ob_get_contents();
        ob_end_clean();
        return $userHeader;
    }



}