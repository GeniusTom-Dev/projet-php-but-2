<?php

class controlCreatePosts
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

    function getCreatePost(): string {
        ob_start();?>

        <article class="postInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
            <form method="post" action="" class="postPublisher">
                <input name="createPost" type="hidden" value="1">
            <main class="max-h-60 overflow-y-auto">
                <div class="flex flex-lign items-center mb-2">
                    <input type="text" name="title" placeholder="Titre du post" class="title-input border border-[#b2a5ff] rounded-md font-bold text-xl">
                    <img src="/html/images/trash-can-solid.svg" alt="trashCan" class="trashCan w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                </div>
                <textarea name="content" placeholder="Écrivez votre contenu ici" class="content-input w-full break-words p-2 border border-[#b2a5ff] rounded-md"></textarea>
                <div class="imageContainer mt-4">
                    <button class="plusButton w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                        <img src="/html/images/plus-solid.svg" alt="plus">
                    </button>
                    <!-- Input de type "file" caché -->
                    <input type="file" class="fileInput" accept="image/*" style="display: none;">
                </div>
                <div class="galleryContainer mt-4"></div>
                <input type="text" placeholder="Nouvelle catégorie" class="categoryInput border border-[#b2a5ff] rounded-md">
                <button class="add-category-button bg-[#b2a5ff] text-white rounded-md px-2 py-1 m-2">Ajouter Catégorie</button>
                <ul class="category-list"></ul>
            </main>
            <footer>
                <img id="paperPlane" src="/html/images/paper-plane-solid.svg" alt="paperPlane" class="paperPlane w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto" onclick="submit()">
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

    public function checkCreatePost(): void{
        if (isset($_POST['createPost'])){
            if (! (empty($_POST['title']) && empty($_POST['content'])) && empty($_POST['img'])){
                $this->publishPost($_POST['title'], $_POST['content'], $_POST['topics'], $_POST['img']);
            }
        }

    }

}