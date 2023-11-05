<?php

namespace GFramework\utilities;

use GFramework\database;

class controlUserProfile
{

    private \GFramework\database\DbUsers $dbUsers;
    private \GFramework\database\DbPosts $dbPosts;
    private \GFramework\database\DbFavorites $dbFavorites;
    private \GFramework\database\DbFollows $dbFollows;

    public controlGeneratePosts $postController;

    public function __construct($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers)
    {
        $this->dbFavorites = $dbFavorites;
        $this->dbFollows = $dbFollows;
        $this->dbPosts = $dbPosts;
        $this->dbUsers = $dbUsers;

        $this->postController = new controlGeneratePosts($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
    }

    public function getUserProfileInfo(int $userID): string
    {
        $userData = $this->dbUsers->selectById($userID)->getContent();
        $owns = isset($_SESSION['suid']) && ($_SESSION['suid'] == $userID);
        ob_start(); ?>

        <header class="article-header relative mb-8">

            <!-- Image de profil utilisateur -->
            <div class="profile-picture" id="profilePicture">
                <img src="<?php if (empty($userData['USER_PROFIL_PIC'])) {
                    echo '/projet-php-but-2/html/images/profile-removebg-preview.png';
                } else {
                    echo $userData['USER_PROFIL_PIC'];
                }
                ?>" alt="Photo de profil" id="profileImage"
                     class="article-image absolute top-0 left-8 w-40 h-40 rounded-full transition-transform hover:scale-125">
            </div>
            <!-- Formulaire pour sélectionner un nouveau fichier de photo de profil -->
            <?php if ($owns) : ?>
                <form method="post" enctype="multipart/form-data">
                    <input type="file" id="fileInputPP" name="fileInputPP" style="display: none" accept="image/*"
                           onchange="this.form.submit()">
                    <input type="hidden" name="userIdPP" value="<?= $userID ?>">
                </form>
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
                        <textarea name="newBio" id="bioTextArea" rows="3" cols="20"
                                  placeholder="Saisissez votre biographie ici" maxlength="200"></textarea>
                        <p id="charCount">Caractères restants : 200</p>
                        <br>
                        <input type="hidden" name="userIdBio" value="<?= $userID ?>">
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

    public function checkNewBio(): void
    {
        if (isset($_POST['userIdBio'])) {
//            echo 'new Bio --------------';
            if (!isset($_POST['newBio'])) {
                $this->dbUsers->updateBio($_POST['userIdBio'], null);
            } else {
                $this->dbUsers->updateBio($_POST['userIdBio'], $_POST['newBio']);
            }
        }
    }

    public function checkNewProfilePic(): void
    {
        if (isset($_POST['userIdPP']) && isset($_FILES['fileInputPP'])) {
            if ($_FILES['fileInputPP']['error'] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['fileInputPP']['name'];
                $image_source = file_get_contents($_FILES['fileInputPP']['tmp_name']);
                $this->dbUsers->updateProfilPic($_POST['userIdPP'], $this->uploadImage($fileName, $image_source));
            }
        }
    }

    public function getUserPosts(int $userID, ?int $limit, ?string $sort): string
    {
        $result = $this->dbPosts->select_SQLResult(null, null, $userID, null, null, $limit, 1, $sort)->getContent();
        ob_start();
        foreach ($result as $post) {
            ?>
            <?= $this->postController->getPostHTML($post['POST_ID']) ?>
            <br>
            <?php
        }
        $userPosts = ob_get_contents();
        ob_end_clean();
        return $userPosts;
    }

    public function getUserBookmarks(int $userID, ?int $limit, ?string $sort): string
    {
        $result = $this->dbFavorites->getUserFavoritePostsID($userID, $limit, 1, $sort)->getContent();
        ob_start();
        foreach ($result as $post) {
            ?>
            <?= $this->postController->getPostHTML($post['POST_ID']) ?>
            <br>
            <?php
        }
        $userFavs = ob_get_contents();
        ob_end_clean();
        return $userFavs;
    }

    public function uploadImage($fileName, $image_source): string|null
    {
        $IMGUR_CLIENT_ID = "d50e66f2514dc6e"; // client id for the website -> do not modify
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // check file extension
        if (in_array($fileType, array('jpg', 'png', 'jpeg'))) {

            // API post parameters
            $postFields = array('image' => base64_encode($image_source));

            // Post image to Imgur via API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $IMGUR_CLIENT_ID));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            $response = curl_exec($ch);
            curl_close($ch);

            // Convert API response to array
            $imgurData = json_decode($response);

            // Check if image has been upload successfully
            if (!empty($imgurData->data->link)) {
                return $imgurData->data->link;
            }
        }
        return null;
    }
}