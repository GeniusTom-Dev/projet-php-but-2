<?php

class controlCreatePosts
{

    private DbPosts $dbPosts;
    private DbTopics $dbTopics;

    public function __construct($conn){
        $this->dbPosts = new DbPosts($conn);
        $this->dbTopics = new DbTopics($conn);
    }

    function publishPost($title, $content, $arrayTopics, $arrayImg = null): void{
        $title = str_replace('\'', '\'\'', $title);
        $content = str_replace('\'', '\'\'', $content);
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

        <article class="postCreationInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
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
                    <table class="w-full">
                        <tr>
                            <td>
                                <?php include '../GFramework/searchBar/onlyTopicSearchBar.php'?>
                                <button type="button" class="add-category-button bg-[#b2a5ff] text-white rounded-md px-2 py-1 m-2">Ajouter Catégorie</button>
                            </td>
                            <td id="categoryList" class="justify-content">
                                <!--<p id="topicsList" class="bg-purple-500 text-white rounded-md px-2 py-1 m-2 text-left inline-block"><?php /*echo "Cuisine"; */?></p>-->
                            </td>
                        </tr>
                    </table>
                    <!--<ul class="category-list"></ul>-->
                </main>
                <footer>
                    <img id="paperPlane" src="/html/images/paper-plane-solid.svg" alt="paperPlane" class="paperPlane w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto" onclick="submit()">
                </footer>
                <div class="deleteConfirmation fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-4 border border-[#b2a5ff] rounded-lg shadow-md" style="display: none;">
                    <p>Voulez-vous vraiment supprimer ce post ?</p>
                    <button class="confirmDeleteButton px-4 py-2 bg-red-500 text-white rounded-md ml-2">Confirmer</button>
                    <button class="cancelDeleteButton px-4 py-2 bg-[#b2a5ff] rounded-md ml-2">Annuler</button>
                </div>
            </form>
        </article>


        <?php $post = ob_get_contents();
        ob_end_clean();
        return $post;
    }

    public function checkCreatePost(): void{
        if (isset($_POST['createPost'])){
            if (! (empty($_POST['title']) && empty($_POST['content']))){
                if (empty($_POST['img'])){
                    $this->publishPost($_POST['title'], $_POST['content'], $_POST['topics']);
                }
                else{
                    $this->publishPost($_POST['title'], $_POST['content'], $_POST['topics'], $_POST['img']);
                }
            }
        }

    }

}