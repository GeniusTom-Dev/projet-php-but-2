<?php

class controlGeneratePosts
{
    private DbUsers $dbUsers;
    private DbPosts $dbPosts;
    private DbTopics $dbTopics;
    private DbLikes $dbLikes;
    private DbFavorites $dbFavorites;
    private DbFollows $dbFollows;
    private DbComments $dbComments;

    public function __construct($conn){
        $this->dbComments = new DbComments($conn);
        $this->dbFavorites = new DbFavorites($conn);
        $this->dbFollows = new DbFollows($conn);
        $this->dbLikes = new DbLikes($conn);
        $this->dbPosts = new DbPosts($conn);
        $this->dbTopics = new DbTopics($conn);
        $this->dbUsers = new DbUsers($conn);
    }

    function getPostHTML(int $postID): string{
        $postData = $this->dbPosts->selectByID($postID)->getContent();
        $owns = isset($_SESSION['suid']) && ( $_SESSION['isAdmin'] || $_SESSION['suid'] == $postData['USER_ID'] );
        ob_start();?>

        <article class="postInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
            <header class="flex flex-lign items-center mb-2">
                <form action="userProfile.php" method="get"> <!-- Affichage page profil utilisateur -->
                    <input type="hidden" name="userProfile" value="<?= $this->dbUsers->selectById($postData['USER_ID'])->getContent()['USERNAME'] ?>">
                    <img src="/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
                </form>
                    <div class="flex flex-col mr-1">
                        <p>@<?= $this->dbUsers->selectById($postData['USER_ID'])->getContent()['USERNAME'] ?></p>
                        <p>Follow | <?= $this->dbFollows->countFollower($postData['USER_ID']) ?> followers</p>
                    </div>

                <form action="affichagePostDetails.php" method="get"> <!-- Affichage page détail post -->
                    <input name="detailsPost" type="hidden" value="<?= $postID ?>">
                    <img src="/html/images/fleches.svg" alt="growArrow" class="growArrow w-8 h-auto transition-transform duration-300 hover:scale-125 ml-auto" onclick="submit()">
                </form>
            </header>
            <main class="max-h-60 overflow-y-auto">
                <div class="flex flex-lign items-center mb-2">
                    <h1 class="mr-2 font-bold text-xl"><?= $postData['TITLE'] ?></h1>
                    <?php if ($owns){?>
                    <img src="/html/images/trash-can-solid.svg" alt="trashCan" class="trashCan w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
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
                        <form method="post">
                            <textarea name="content" placeholder="Ajoutez un commentaire..." class="comment-input w-full p-2 border border-[#b2a5ff] rounded-md"></textarea>
                            <button name="createComment" class="comment-button ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"';?> value="<?= $postID ?>">Poster</button>
                        </form>
                    </div>
                </div>
                <div>
                    <form method="post">
                        <?php if (isset($_SESSION['suid']) && $this->dbLikes->doesUserHasLikedThisPost($_SESSION['suid'], $postID)){ ?>
                            <input type="hidden" name="dislikePost" value="<?= $postID ?>">
                            <img src="/html/images/heart-solid.svg" alt="heart" class="heart w-8 h-auto transition-transform duration-300 hover:scale-125" onclick="submit()">
                        <?php } else {?>
                            <input type="hidden" name="likePost" value="<?= $postID ?>">
                            <img src="/html/images/heart-regular.svg" alt="heart" class="heart w-8 h-auto transition-transform duration-300 hover:scale-125" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"';?>>
                        <?php } ?>
                    </form>
                    <p><?= $this->dbLikes->countPostLike($postID) ?></p>
                    <form method="post">
                        <?php if (isset($_SESSION['suid']) && $this->dbFavorites->doesUserHaveFavoritedThisPost($_SESSION['suid'], $postID)){ ?>
                            <input type="hidden" name="unmarkPost" value="<?= $postID ?>">
                            <img src="/html/images/bookmark-solid.svg" alt="bookmark" class="bookmark w-8 h-auto transition-transform duration-300 hover:scale-125" onclick="submit()">
                        <?php } else {?>
                            <input type="hidden" name="markPost" value="<?= $postID ?>">
                            <img src="/html/images/bookmark-regular.svg" alt="bookmark" class="bookmark w-8 h-auto transition-transform duration-300 hover:scale-125" <?php if (isset($_SESSION['suid'])) echo 'onclick="submit()"';?>>
                        <?php } ?>
                    </form>
                </div>
            </footer>
            <div class="deleteConfirmation fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md" style="display: none;">
                <p>Voulez-vous vraiment supprimer ce post ?</p>
                <form method="post">
                    <button class="confirmDeleteButton px-4 py-2 bg-red-500 text-white rounded-md ml-2" onclick="submit()" name="deletePost" value="<?= $postID ?>">Confirmer</button>
                </form>
                <button class="cancelDeleteButton px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
            </div>
        </article>

        <?php $post = ob_get_contents();
        ob_end_clean();
        return $post;
    }
    
    public function checkAllShowActions(): void{
        $this->checkDeletePost();
        $this->checkCreateComment();
        $this->checkDeleteComment();
        $this->checkLike();
        $this->checkDislike();
        $this->checkMark();
        $this->checkUnmark();

    }

    private function checkDeletePost(): void{
        if (isset($_POST['deletePost'])){
            $this->dbPosts->deletePost($_POST['deletePost']);
        }
    }
    private function checkCreateComment(): void{
        if (isset($_POST['createComment']) && isset($_POST['content'])){
            $this->dbComments->addComment($_POST['createComment'], $_SESSION['suid'], $_POST['content'], date('Y-m-d'));
        }
    }
    private function checkDeleteComment(): void{
        if (isset($_POST['deleteComment']) && isset($_POST['content'])){
            $this->dbComments->deleteComment($_POST['deleteComment']);
        }
    }
    private function checkLike(): void{
        if (isset($_POST['likePost'])){
            $this->dbLikes->addLike($_SESSION['suid'], $_POST['likePost']);
        }
    }
    private function checkDislike(): void{
        if (isset($_POST['dislikePost'])){
            $this->dbLikes->removeLike($_SESSION['suid'], $_POST['dislikePost']);
        }
    }
    private function checkMark(): void{
        if (isset($_POST['markPost'])){
            $this->dbFavorites->addFavorite($_SESSION['suid'], $_POST['markPost']);
        }
    }
    private function checkUnmark(): void{
        if (isset($_POST['unmarkPost'])){
            $this->dbFavorites->removeFavorite($_SESSION['suid'], $_POST['unmarkPost']);
        }
    }
}