<?php

namespace GFramework\utilities;

class controlGenerateFullPosts
{
    private \GFramework\database\DbUsers $dbUsers;
    private \GFramework\database\DbPosts $dbPosts;
    private \GFramework\database\DbTopics $dbTopics;
    private \GFramework\database\DbLikes $dbLikes;
    private \GFramework\database\DbFavorites $dbFavorites;
    private \GFramework\database\DbFollows $dbFollows;
    private \GFramework\database\DbComments $dbComments;

    public function __construct($conn)
    {
        $this->dbComments = new \GFramework\database\DbComments($conn);
        $this->dbFavorites = new \GFramework\database\DbFavorites($conn);
        $this->dbFollows = new \GFramework\database\DbFollows($conn);
        $this->dbLikes = new \GFramework\database\DbLikes($conn);
        $this->dbPosts = new \GFramework\database\DbPosts($conn);
        $this->dbTopics = new \GFramework\database\DbTopics($conn);
        $this->dbUsers = new \GFramework\database\DbUsers($conn);
    }

    function getFullPostHTML(int $postID): string
    {
        $postData = $this->dbPosts->selectByID($postID)->getContent();
        $userData = $this->dbUsers->selectById($postData['USER_ID'])->getContent();
        $owns = (isset($_SESSION['suid']) && ($_SESSION['isAdmin'] || $_SESSION['suid'] == $postData['USER_ID']));
        ob_start(); ?>

        <article
                class="postInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
            <header class="flex flex-lign items-center mb-2">
                <form action="userProfile.php" method="get"> <!-- Affichage page profil utilisateur -->
                    <input type="hidden" name="userProfile" value="<?= $userData['USER_ID'] ?>">
                    <?php
                    if (is_null($userData['USER_PROFIL_PIC'])) {
                        echo '<img src="/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">';
                    } else {
                        echo '<img src="' . $userData['USER_PROFIL_PIC'] . '" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">';
                    }
                    ?>
                    <div class="flex flex-col mr-1">
                        <p>@<?= $userData['USERNAME'] ?></p>
                        <p>Follow | <?= $this->dbFollows->countFollower($postData['USER_ID']) ?> followers</p>
                    </div>
                </form>
                <form method="post">
                    <?php if (isset($_SESSION['suid']) && $postData['USER_ID'] != $_SESSION['suid']) {
                        if ($this->dbFollows->doesUserFollowAnotherUser($_SESSION['suid'], $postData['USER_ID'])) { ?>
                            <button class="suscribe-button ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md"
                                    onclick="submit()" name="unsubscribe" value="<?= $postData['USER_ID'] ?>">Se
                                désabonner
                            </button>
                        <?php } else { ?>
                            <button class="suscribe-button ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md"
                                    onclick="submit()" name="subscribe" value="<?= $postData['USER_ID'] ?>">S'abonner
                            </button>
                        <?php }
                    } ?>
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
                <div class="comment-section p-4 max-h-40 overflow-y-auto">
                    <h2 class="mb-4 font-bold text-xl">Commentaires</h2>
                    <div class="flex items-center mb-2">
                        <form name="createCommentForm" method="post">
                            <textarea name="content" placeholder="Ajoutez un commentaire..."
                                      class="comment-input w-full p-2 border border-[#b2a5ff] rounded-md"></textarea>
                            <button name="createComment"
                                    class="comment-button ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"'; ?>
                                    value="<?= $postID ?>">Poster
                            </button>
                        </form>
                    </div>
                    <div class="comments-container max-h-40 overflow-y-auto">
                        <?php foreach ($this->dbComments->getPostComments($postID) as $comment) {
                            echo PHP_EOL . $this->getComment($comment['COMMENT_ID'], $comment['USER_ID'], $comment['CONTENT']);
                        } ?>
                    </div>
                </div>
                <div>
                    <form name="LikeForm" method="post">
                        <?php if (isset($_SESSION['suid']) && $this->dbLikes->doesUserHasLikedThisPost($_SESSION['suid'], $postID)) { ?>
                            <input type="hidden" name="dislikePost" value="<?= $postID ?>">
                            <img src="/html/images/heart-solid.svg" alt="heart"
                                 class="heart w-8 h-auto transition-transform duration-300 hover:scale-125"
                                 onclick="submit()">
                        <?php } else { ?>
                            <input type="hidden" name="likePost" value="<?= $postID ?>">
                            <img src="/html/images/heart-regular.svg" alt="heart"
                                 class="heart w-8 h-auto transition-transform duration-300 hover:scale-125" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"'; ?>>
                        <?php } ?>
                    </form>
                    <p><?= $this->dbLikes->countPostLike($postID) ?></p>
                    <form name="MarkForm" method="post">
                        <?php if (isset($_SESSION['suid']) && $this->dbFavorites->doesUserHaveFavoritedThisPost($_SESSION['suid'], $postID)) { ?>
                            <input type="hidden" name="unmarkPost" value="<?= $postID ?>">
                            <img src="/html/images/bookmark-solid.svg" alt="bookmark"
                                 class="bookmark w-8 h-auto transition-transform duration-300 hover:scale-125"
                                 onclick="submit()">
                        <?php } else { ?>
                            <input type="hidden" name="markPost" value="<?= $postID ?>">
                            <img src="/html/images/bookmark-regular.svg" alt="bookmark"
                                 class="bookmark w-8 h-auto transition-transform duration-300 hover:scale-125" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"'; ?>>
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

    public function getComment(int $commentID, int $userID, string $content): string
    {
        $owns = isset($_SESSION['suid']) && ($_SESSION['isAdmin'] || $_SESSION['suid'] == $userID);
        ob_start(); ?>
        <div class="flex items-center mb-2">
            <img src="/html/images/profile-removebg-preview.png" alt="PP"
                 class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
            <p>@<?= $this->dbUsers->selectById($userID)->getContent()['USERNAME'] ?></p>
            <p class="w-full p-2 border border-[#b2a5ff] rounded-md"><?= $content ?></p>
            <?php if ($owns) { ?>
                <form name="deleteComment" method="post">
                    <button id="delete-comment-button" name="deleteComment"
                            class="ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md" onclick="submit()"
                            value="<?= $commentID ?>">Delete
                    </button>
                </form>
            <?php } ?>
        </div>
        <?php $comment = ob_get_contents();
        ob_end_clean();
        return $comment;
    }

    public function checkAllShowActions(): void
    {
        $this->checkDeletePost();
        $this->checkSubscribe();
        $this->checkUnsubscribe();
        $this->checkCreateComment();
        $this->checkDeleteComment();
        $this->checkLike();
        $this->checkDislike();
        $this->checkMark();
        $this->checkUnmark();

    }

    public function checkPostId(): void
    {
        if (isset($_GET['detailsPost'])) {
            $_SESSION['detailsPost'] = $_GET['detailsPost'];
        } else {
            if (empty($_SESSION['detailsPost'])) {
                $_SESSION['detailsPost'] = 1;
            }
            $_GET['detailsPost'] = $_SESSION['detailsPost'];
        }
    }

    private function checkSubscribe(): void
    {
        if (isset($_POST['subscribe'])) {
            $this->dbFollows->addFollow($_SESSION['suid'], $_POST['subscribe']);
        }
    }

    private function checkUnsubscribe(): void
    {
        if (isset($_POST['unsubscribe'])) {
            $this->dbFollows->removeFollow($_SESSION['suid'], $_POST['unsubscribe']);
        }
    }

    private function checkDeletePost(): void
    {
        if (isset($_POST['deletePost'])) {
            $this->dbPosts->deletePost($_POST['deletePost']);
            unset($_SESSION['detailPost']);
            header('Location: affichagePost.php');
            die();
        }
    }

    private function checkCreateComment(): void
    {
        if (isset($_POST['createComment']) && isset($_POST['content'])) {
            $content = str_replace('\'', '\'\'', $_POST['content']);
            $this->dbComments->addComment($_POST['createComment'], $_SESSION['suid'], $content, date('Y-m-d'));
        }
    }

    private function checkDeleteComment(): void
    {
        if (isset($_POST['deleteComment'])) {
            $this->dbComments->deleteComment($_POST['deleteComment']);
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