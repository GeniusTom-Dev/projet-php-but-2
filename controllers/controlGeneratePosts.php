<?php

class controlGeneratePosts
{
    private DbUsers $dbUsers;
    private DbPosts $dbPosts;
    private DbTopics $dbTopics;
    private DbLikes $dbLikes;
    private DbFavorites $dbFavorites;
    private DbFollows $dbFollows;

    public function __construct($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers)
    {
        $this->dbFavorites = $dbFavorites;
        $this->dbFollows = $dbFollows;
        $this->dbLikes = $dbLikes;
        $this->dbPosts = $dbPosts;
        $this->dbTopics = $dbTopics;
        $this->dbUsers = $dbUsers;
    }

    function getPostHTML(int $postID): string
    {
        $postData = $this->dbPosts->selectByID($postID)->getContent();
        $userData = $this->dbUsers->selectById($postData['USER_ID'])->getContent();
        $owns = isset($_SESSION['suid']) && ($_SESSION['isAdmin'] || $_SESSION['suid'] == $postData['USER_ID']);
        ob_start(); ?>

        <article
                class="postInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6 mb-4">
            <header class="flex flex-lign items-center mb-2">
                <form action="pageProfil.php" method="get"> <!-- Affichage page profil utilisateur -->
                    <input type="hidden" name="userProfile" value="<?= $userData['USERNAME'] ?>">
                    <div class="w-100 h-100">
                        <?php
                        if (is_null($userData['USER_PROFIL_PIC'])) {
                            echo '<img src="/projet-php-but-2/html/images/defaultProfilePicture.png" onclick="submit()" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">';
                        } else {
                            echo '<img src="' . $userData['USER_PROFIL_PIC'] . '" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1" onclick="submit()">';
                        }
                        ?>
                    </div>
                </form>
                <div class="flex flex-col mr-1">
                    <p>@<?= $userData['USERNAME'] ?></p>
                    <p>Follow | <?= $this->dbFollows->countFollower($postData['USER_ID']) ?> followers</p>
                </div>

                <form action="/projet-php-but-2/View/affichagePostDetails.php" method="get">
                    <!-- Affichage page détail post -->
                    <input name="detailsPost" type="hidden" value="<?= $postID ?>">
                    <img src="/projet-php-but-2/html/images/fleches.svg" alt="growArrow"
                         class="growArrow w-10 h-auto transition-transform duration-300 hover:scale-125 ml-auto"
                         onclick="submit()">
                </form>
            </header>
            <main class="max-h-60 overflow-y-auto">
                <div class="flex flex-lign items-center mb-2">
                    <h1 class="mr-2 font-bold text-xl"><?= $postData['TITLE'] ?></h1>
                    <?php if ($owns) { ?>
                        <img src="/html/images/trash-can-solid.svg" alt="trashCan"
                             class="trashCan w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                    <?php } ?>
                </div>
                <p><?= $postData['CONTENT'] ?></p>

                <div class="galleryContainer mt-4">
                    <!-- Lien BD et image -->
                </div>
                <?php foreach ($this->dbPosts->getLinkedTopics($postID) as $topicID) { ?>
                    <button class="bg-purple-500 text-white rounded-md px-2 py-1 m-2"><?= $this->dbTopics->selectById($topicID['TOPIC_ID'])->getContent()['NAME'] ?></button>
                <?php } ?>
            </main>
            <footer>
                <div class="flex flex-lign items-center mb-2">
                    <form method="post">
                        <?php if (isset($_SESSION['suid']) && $this->dbLikes->doesUserHasLikedThisPost($_SESSION['suid'], $postID)) { ?>
                            <input type="hidden" name="dislikePost" value="<?= $postID ?>">
                            <img src="/projet-php-but-2/html/images/heart-solid.svg" alt="heart"
                                 class="heart w-8 h-auto transition-transform duration-300 hover:scale-125 mr-2"
                                 onclick="submit()">
                        <?php } else { ?>
                            <input type="hidden" name="likePost" value="<?= $postID ?>">
                            <img src="/projet-php-but-2/html/images/heart-regular.svg" alt="heart"
                                 class="heart w-8 h-auto transition-transform duration-300 hover:scale-125 mr-2" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"'; ?>>
                        <?php } ?>
                    </form>
                    <p><?= $this->dbLikes->countPostLike($postID) ?></p>
                    <form method="post">
                        <?php if (isset($_SESSION['suid']) && $this->dbFavorites->doesUserHaveFavoritedThisPost($_SESSION['suid'], $postID)) { ?>
                            <input type="hidden" name="unmarkPost" value="<?= $postID ?>">
                            <img src="/projet-php-but-2/html/images/bookmark-solid.svg" alt="bookmark"
                                 class="bookmark w-6 h-auto transition-transform duration-300 hover:scale-125 mr-2"
                                 onclick="submit()">
                        <?php } else { ?>
                            <input type="hidden" name="markPost" value="<?= $postID ?>">
                            <img src="/projet-php-but-2/html/images/bookmark-regular.svg" alt="bookmark"
                                 class="bookmark w-6 h-auto transition-transform duration-300 hover:scale-125 mr-2" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"'; ?>>
                        <?php } ?>
                    </form>
                </div>
            </footer>
            <div class="deleteConfirmation fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md"
                 style="display: none;">
                <p>Voulez-vous vraiment supprimer ce post ?</p>
                <form method="post">
                    <button class="confirmDeleteButton px-4 py-2 bg-red-500 text-white rounded-md ml-2"
                            onclick="submit()" name="deletePost" value="<?= $postID ?>">Confirmer
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
        $this->checkLike();
        $this->checkDislike();
        $this->checkMark();
        $this->checkUnmark();

    }

    private function checkDeletePost(): void
    {
        if (isset($_POST['deletePost'])) {
            $this->dbPosts->deletePost($_POST['deletePost']);
        }
    }

    private function checkLike(): void
    {
        if (isset($_POST['likePost'])) {
            $this->dbLikes->addLike($_SESSION['suid'], $_POST['likePost']);
        }
    }

    private function checkDislike(): void
    {
        if (isset($_POST['dislikePost'])) {
            $this->dbLikes->removeLike($_SESSION['suid'], $_POST['dislikePost']);
        }
    }

    private function checkMark(): void
    {
        if (isset($_POST['markPost'])) {
            $this->dbFavorites->addFavorite($_SESSION['suid'], $_POST['markPost']);
        }
    }

    private function checkUnmark(): void
    {
        if (isset($_POST['unmarkPost'])) {
            $this->dbFavorites->removeFavorite($_SESSION['suid'], $_POST['unmarkPost']);
        }
    }
}