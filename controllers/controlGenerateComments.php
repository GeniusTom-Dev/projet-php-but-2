<?php

namespace controllers;

use DbPosts;
use DbUsers;
use DbComments;
use DbFollows;

class controlGenerateComments
{
    private DbComments $dbComments;
    private DbPosts $dbPosts;
    private DbUsers $dbUsers;
    private DbFollows $dbFollows;

    public function __construct($dbComments, $dbPosts, $dbUsers, $dbFollows)
    {
        $this->dbComments = $dbComments;
        $this->dbPosts = $dbPosts;
        $this->dbUsers = $dbUsers;
        $this->dbFollows = $dbFollows;
    }

    function getCommentHTML(int $commentId): string
    {
        $commentData = $this->dbComments->selectByID($commentId);
        $postData = $this->dbPosts->selectByID($commentId['POST_ID'])->getContent();
        $userData = $this->dbUsers->selectById($commentId['USER_ID'])->getContent();
        $owns = isset($_SESSION['suid']) && ($_SESSION['isAdmin'] || $_SESSION['suid'] == $postData['USER_ID']);
        ob_start(); ?>
        <article
                class="commentInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6 mb-4">
            <header class="flex flex-lign items-center mb-2">
                <form action="pageProfil.php" method="get"> <!-- Affichage page profil utilisateur -->
                    <input type="hidden" name="userProfile" value="<?= $userData['USERNAME'] ?>">
                    <div class="w-100 h-100">
                        <?php
                        if (is_null($userData['USER_PROFIL_PIC'])) {
                            echo '<img src="/projet-php-but-2/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">';
                        } else {
                            echo '<img src="' . $userData['USER_PROFIL_PIC'] . '" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">';
                        }
                        ?>
                    </div>
                </form>
                <div class="flex flex-col mr-1">
                    <p>@<?= $userData['USERNAME'] ?></p>
                    <p>Follow | <?= $this->dbFollows->countFollower($commentData['USER_ID']) ?> followers</p>
                </div>

                <form action="/projet-php-but-2/View/affichagePostDetails.php" method="get">
                    <!-- Affichage page détail post -->
                    <input name="detailsPost" type="hidden" value="<?= $postData['POST_ID'] ?>">
                    <img src="/projet-php-but-2/html/images/fleches.svg" alt="growArrow"
                         class="growArrow w-10 h-auto transition-transform duration-300 hover:scale-125 ml-auto"
                         onclick="submit()">
                </form>
            </header>
            <main class="max-h-60 overflow-y-auto">
                <div class="flex flex-lign items-center mb-2">
                    <?php if ($owns) { ?>
                        <img src="/html/images/trash-can-solid.svg" alt="trashCan"
                             class="trashCan w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                    <?php } ?>
                </div>
                <p><?= $commentData['CONTENT'] ?></p>
            </main>
            <div class="deleteConfirmation fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md"
                 style="display: none;">
                <p>Voulez-vous vraiment supprimer ce post ?</p>
                <form method="post">
                    <button class="confirmDeleteButton px-4 py-2 bg-red-500 text-white rounded-md ml-2"
                            onclick="submit()" name="deletePost" value="<?= $commentId ?>">Confirmer
                    </button>
                </form>
                <button class="cancelDeleteButton px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
            </div>
        </article>
        <?php $post = ob_get_contents();
        ob_end_clean();
        return $post;
    }

    public function checkAllShowActions(): void
    {
        $this->checkDeletePost();
    }

    private function checkDeletePost(): void
    {
        if (isset($_POST['deletePost'])) {
            $this->dbPosts->deletePost($_POST['deletePost']);
        }
    }
}