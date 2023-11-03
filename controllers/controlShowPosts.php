<?php

class controlShowPosts
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

    function publishPost($title, $content, $arrayTopics, $arrayImg): void{
        // Publish the post
        $postID = $this->dbPosts->addPost($_SESSION['suid'], $title, $content, date('Y-m-d'));
        // Link the post to the associated topics
        foreach ($arrayTopics as $topic){
            $topicFound = $this->dbTopics->selectByName($topic)->getContent();
            if ($topicFound != null){
                $this->dbPosts->linkPostToTopic($postID, $topicFound['TOPIC_ID']);
            }
        }
        // Link images to the post
    }

    function deletePost(int $postID): void{
        $this->dbPosts->deletePost($postID);
    }

    function likePost(int $postID): void{
        $this->dbLikes->addLike($_SESSION['suid'], $postID);
    }

    function unlikePost(int $postID): void{
        $this->dbLikes->removeLike($_SESSION['suid'], $postID);
    }

    function addFavPost(int $postID): void{
        $this->dbFavorites->addFavorite($_SESSION['suid'], $postID);
    }

    function removeFavPost(int $postID): void{
        $this->dbFavorites->removeFavorite($_SESSION['suid'], $postID);
    }

    function getCreatePost(): string {
        ob_start();?>

        <article id="article" class="postInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
            <main class="max-h-60 overflow-y-auto">
                <div class="flex flex-lign items-center mb-2">
                    <input type="text" placeholder="Titre du post" class="title-input border border-[#b2a5ff] rounded-md font-bold text-xl">
                    <img src="/html/images/trash-can-solid.svg" alt="trashCan" class="trashCan w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                </div>
                <textarea placeholder="Écrivez votre contenu ici" class="content-input w-full break-words p-2 border border-[#b2a5ff] rounded-md"></textarea>
                <div class="imageContainer mt-4">
                    <button id="plusButton" class="w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                        <img src="/html/images/plus-solid.svg" alt="plus">
                    </button>
                    <!-- Input de type "file" caché -->
                    <input type="file" id="fileInput" accept="image/*" style="display: none;">
                </div>
                <div class="galleryContainer mt-4"></div>
                <input type="text" placeholder="Nouvelle catégorie" class="categoryInput border border-[#b2a5ff] rounded-md">
                <button class="add-category-button bg-[#b2a5ff] text-white rounded-md px-2 py-1 m-2">Ajouter Catégorie</button>
                <ul class="category-list"></ul>
            </main>
            <footer>
                <img src="/html/images/paper-plane-solid.svg" alt="paperPlane" class="paperPlane w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
            </footer>
            <div class="deleteConfirmation fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md" style="display: none;">
                <p>Voulez-vous vraiment supprimer ce post ?</p>
                <button class="confirmDeleteButton px-4 py-2 bg-red-500 text-white rounded-md ml-2">Confirmer</button>
                <button class="cancelDeleteButton px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
            </div>
        </article>

        <?php $post = ob_get_contents();
        ob_end_clean();
        return $post;
    }

    function getFullPostHTML(int $postID): string{
        $postData = $this->dbPosts->selectByID($postID)->getContent();
        ob_start();?>

        <article id="article" class="w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
            <header class="flex flex-lign items-center mb-2">
                <img src="/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
                <div class="flex flex-col mr-1">
                    <p>@<?= $this->dbUsers->selectById($postData['USER_ID'])->getContent()['USERNAME'] ?></p>
                    <p>Follow | <?= $this->dbFollows->countFollower($postData['USER_ID']) ?> followers</p>
                </div>
                <button id="suscribe-button" class="ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md">S'abonner</button>

            </header>
            <main class="max-h-60 overflow-y-auto">
                <div class="flex flex-lign items-center mb-2">
                    <h1 class="mr-2 font-bold text-xl"><?= $postData['TITLE'] ?></h1>
                    <img id="trashCan" src="/html/images/trash-can-solid.svg" alt="trashCan" class="w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                </div>
                <p><?= $postData['CONTENT'] ?></p>

                <div id="galleryContainer" class="mt-4"></div>
                <?php foreach ($this->dbPosts->getLinkedTopics($postID) as $topicID) { ?>
                    <button class="bg-purple-500 text-white rounded-md px-2 py-1 m-2"><?= $this->dbTopics->selectById($topicID['TOPIC_ID'])->getContent()['NAME'] ?></button>
                <?php } ?>
            </main>
            <footer>
                <div id="comment-section" class="p-4 max-h-40 overflow-y-auto">
                    <h2 class="mb-4 font-bold text-xl">Commentaires</h2>
                    <div class="flex items-center mb-2">
                        <textarea id="comment-input" placeholder="Ajoutez un commentaire..." class="w-full p-2 border border-[#b2a5ff] rounded-md"></textarea>
                        <button id="comment-button" class="ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md">Poster</button>
                    </div>
                    <div id="comments-container" class="max-h-40 overflow-y-auto">
                        <?php foreach ($this->dbComments->getPostComments($postID) as $comment){
                            echo PHP_EOL . $this->showComment($comment['COMMENT_ID'], $comment['USER_ID'], $comment['CONTENT']);
                        }?>
                    </div>
                </div>
                <div>
                    <img id="heartRegular" src="/html/images/heart-regular.svg" alt="heart" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
                    <img id="bookmarkRegular" src="/html/images/bookmark-regular.svg" alt="bookmark" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
                    <img id="paperPlane" src="/html/images/paper-plane-solid.svg" alt="paperPlane" class="w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                </div>
            </footer>
            <div id="deleteConfirmation" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md" style="display: none;">
                <p>Voulez-vous vraiment supprimer ce post ?</p>
                <button id="confirmDeleteButton" class="px-4 py-2 bg-red-500 text-white rounded-md ml-2">Confirmer</button>
                <button id="cancelDeleteButton" class="px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
            </div>
        </article>

        <?php $post = ob_get_contents();
        ob_end_clean();
        return $post;
    }

    function getPostHTML(int $postID): string{
        $postData = $this->dbPosts->selectByID($postID)->getContent();
        ob_start();?>

        <article id="article" class="w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
            <header class="flex flex-lign items-center mb-2">
                <img src="/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
                <div class="flex flex-col mr-1">
                    <p>@<?= $this->dbUsers->selectById($postData['USER_ID'])->getContent()['USERNAME'] ?></p>
                    <p>Follow | <?= $this->dbFollows->countFollower($postData['USER_ID']) ?> followers</p>
                </div>
                <form action=""> <!-- Affichage page détail post -->
                    <img id="growArrow" src="/html/images/fleches.svg" alt="growArrow" class="w-8 h-auto transition-transform duration-300 hover:scale-125 ml-auto" onclick="submit()">
                </form>
            </header>
            <main class="max-h-60 overflow-y-auto">
                <div class="flex flex-lign items-center mb-2">
                    <h1 class="mr-2 font-bold text-xl"><?= $postData['TITLE'] ?></h1>
                    <img id="trashCan" src="/html/images/trash-can-solid.svg" alt="trashCan" class="w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                </div>
                <p><?= $postData['CONTENT'] ?></p>

                <div id="galleryContainer" class="mt-4"></div>
                <?php foreach ($this->dbPosts->getLinkedTopics($postID) as $topicID) { ?>
                    <button class="bg-purple-500 text-white rounded-md px-2 py-1 m-2"><?= $this->dbTopics->selectById($topicID['TOPIC_ID'])->getContent()['NAME'] ?></button>
                <?php } ?>
            </main>
            <footer>
                <div id="comment-section" class="p-4 max-h-40 overflow-y-auto">
                    <h2 class="mb-4 font-bold text-xl">Commentaires</h2>
                    <div class="flex items-center mb-2">
                        <textarea id="comment-input" placeholder="Ajoutez un commentaire..." class="w-full p-2 border border-[#b2a5ff] rounded-md"></textarea>
                        <button id="comment-button" class="ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md">Poster</button>
                    </div>
                </div>
                <div>
                    <img id="heartRegular" src="/html/images/heart-regular.svg" alt="heart" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
                    <img id="bookmarkRegular" src="/html/images/bookmark-regular.svg" alt="bookmark" class="w-8 h-auto transition-transform duration-300 hover:scale-125">
                    <img id="paperPlane" src="/html/images/paper-plane-solid.svg" alt="paperPlane" class="w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                </div>
            </footer>
            <div id="deleteConfirmation" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md" style="display: none;">
                <p>Voulez-vous vraiment supprimer ce post ?</p>
                <button id="confirmDeleteButton" class="px-4 py-2 bg-red-500 text-white rounded-md ml-2">Confirmer</button>
                <button id="cancelDeleteButton" class="px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
            </div>
        </article>

        <?php $post = ob_get_contents();
        ob_end_clean();
        return $post;
    }

    public function showComment(int $commentID, int $userID, string $content): string{
        ob_start();?>
        <div class="flex items-center mb-2">
            <img src="/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
            <p>@<?= $this->dbUsers->selectById($userID)->getContent()['USERNAME'] ?></p>
            <p class="w-full p-2 border border-[#b2a5ff] rounded-md"><?= $content ?></p>
            <button id="delete-comment-button" name="deleteComment" class="ml-2 px-4 py-2 bg-[#b2a5ff] text-white rounded-md" value="<?= $commentID ?>">Delete</button>
        </div>
        <?php $comment = ob_get_contents();
        ob_end_clean();
        return $comment;
    }

}