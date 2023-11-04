<?php

class controlUserProfile
{

    private DbUsers $dbUsers;
    private DbPosts $dbPosts;
    private DbFavorites $dbFavorites;
    private DbFollows $dbFollows;
    public controlGeneratePosts $postController;

    private mysqli $dbConn;

    public function __construct($conn){
        $this->dbConn = $conn;
        $this->dbFavorites = new DbFavorites($conn);
        $this->dbFollows = new DbFollows($conn);
        $this->dbPosts = new DbPosts($conn);
        $this->dbUsers = new DbUsers($conn);
        $this->postController = new controlGeneratePosts($conn);
    }

    public function getUserProfileInfo(int $userID): string{
        $userData = $this->dbUsers->selectById($userID)->getContent();
        $owns = isset($_SESSION['suid']) && ($_SESSION['suid'] == $userID);
        ob_start();?>

        <header class="article-header relative mb-8">

            <!-- Image de profil utilisateur -->
            <div class="profile-picture" id="profilePicture">
                <img src="<?php if (empty($userData['USER_PROFIL_PIC'])){
                    echo '/projet-php-but-2/html/images/profile-removebg-preview.png';
                }
                else{
                    echo $userData['USER_PROFIL_PIC'];
                }
                ?>" alt="Photo de profil" id="profileImage"  class="article-image absolute top-0 left-8 w-40 h-40 rounded-full transition-transform hover:scale-125">
            </div>
            <!-- Formulaire pour sélectionner un nouveau fichier de photo de profil -->
            <?php if ($owns) : ?>
                <input type="file" id="fileInputPP" style="display: none" accept="image/*">
            <?php endif; ?>
            <!-- Informations de profil -->
            <div class="pl-64">
                <p class="text-xl font-bold"><?= $userData['USERNAME'] ?></p>
                <p class="mb-2">Follow <?= $this->dbFollows->countFollower($userID) ?></p>
                <p class="mb-2">Abonnement <?= $this->dbFollows->countFollowed($userID) ?></p>
                <p class="mb-2">Dernière connexion : <?= $userData['USER_LAST_CONNECTION'] ?></p>
                <!-- Section de la biographie et du formulaire de modification -->
                <div class="bio" id="bioContainer">
                    <h1>Ma Biographie :</h1>
                    <p id="userBio"><?= $userData['USER_BIO'] ?></p>
                </div>

                <div class="bio-form" id="bioForm" style="display: none;">
                    <form id="editForm" method="post">
                        <textarea name="newBio" id="bioTextArea" rows="3" cols="20" placeholder="Saisissez votre biographie ici" maxlength="200"></textarea>
                        <p id="charCount">Caractères restants : 200</p>
                        <br>
                        <input type="hidden" name="userNewBio" value="<?= $userID ?>">
                        <input type="submit" value="Enregistrer">
                    </form>
                </div>
                <?php if ($owns) : ?>
                    <!-- Bouton pour modifier la biographie -->
                    <button id="editButton">Modifier Ma Biographie</button>
                <?php endif; ?>
        </header>

        <?php $userHeader = ob_get_contents();
        ob_end_clean();
        return $userHeader;
    }

    public function checkNewBio(): void{
        if (isset($_POST['userNewBio'])){
//            echo 'new Bio --------------';
            if (!isset($_POST['newBio'])){
                $this->dbUsers->updateBio($_POST['userNewBio'], null);
            }
            else{
                $this->dbUsers->updateBio($_POST['userNewBio'], $_POST['newBio']);
            }
        }
    }

    public function checkNewProfilePic(): void{
        if (isset($_POST['userNewBio'])){
            if (!isset($_POST['newBio'])){
                $this->dbUsers->updateBio($_POST['userNewBio'], null);
            }
            else{
                $this->dbUsers->updateBio($_POST['userNewBio'], $_POST['newBio']);
            }
        }
    }

    public function getUserPosts(int $userID, ?int $limit, ?string $sort){
        $result = $this->dbPosts->select_SQLResult(null, null, $userID, null, null, $limit, 1, $sort)->getContent();
        ob_start();
        foreach ($result as $post){
        ?>
            <?= $this->postController->getPostHTML($post['POST_ID'])?>
            <br>
        <?php
        }
        $userPosts = ob_get_contents();
        ob_end_clean();
        return $userPosts;
    }

    public function getUserBookmarks(int $userID, ?int $limit, ?string $sort){
        $result = $this->dbFavorites->getUserFavoritePostsID($userID, $limit, 1, $sort)->getContent();
        ob_start();
        foreach ($result as $post){
            ?>
            <?= $this->postController->getPostHTML($post['POST_ID'])?>
            <br>
            <?php
        }
        $userFavs = ob_get_contents();
        ob_end_clean();
        return $userFavs;
    }

}