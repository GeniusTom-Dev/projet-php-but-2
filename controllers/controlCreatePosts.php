<?php

class controlCreatePosts
{
    private DbPosts $dbPosts;
    private DbTopics $dbTopics;
    private DbPostMedia $dbPostMedia;

    public function __construct($conn){
        $this->dbPosts = new DbPosts($conn);
        $this->dbTopics = new DbTopics($conn);
        $this->dbPostMedia = new DbPostMedia($conn);
    }

    function publishPost($title, $content, $arrayTopics = null, $arrayImg = null): int{
        $title = str_replace('\'', '\'\'', $title);
        $content = str_replace('\'', '\'\'', $content);
        // Publish the post
        $postID = $this->dbPosts->addPost($_SESSION['suid'], $title, $content, date('Y-m-d'));
        // Link the post to the associated topics
        if (!empty($arrayTopics)) {
            foreach ($arrayTopics as $topic) {
                $topicFound = $this->dbTopics->selectByName($topic)->getContent();
                if ($topicFound != null) {
                    $this->dbPosts->linkPostToTopic($postID, $topicFound['TOPIC_ID']);
                }
            }
        }
        /*// Link images to the post
        if (!empty($arrayImg)){
            foreach ($arrayImg as $img){
                if ($img['error'] === UPLOAD_ERR_OK) {
                    $fileName = $_FILES['fileInputPP']['name'];
                    $image_source = file_get_contents($_FILES['fileInputPP']['tmp_name']);
                    $url = $this->uploadImage($fileName, $image_source);
                    if (!empty($url)){
                        $this->dbPostMedia->addAnImageToPost($postID, $url);
                    }
                    else{
//                        echo 'No URL for Img    ';
                    }
                }
            }
        }*/
        return $postID;
    }

    function getCreatePost(): string {
        ob_start();?>

        <article class="postCreationInterface w-full md:w-1/2 lg:w-1/3 xl:w-1/2 h-auto md:h-1/3 lg:h-auto xl:h-auto bg-gray-100 rounded-lg shadow-md p-6">
            <form method="post" enctype="multipart/form-data" class="postPublisher" >
                <input name="createPost" type="hidden" value="1">
                <main class="max-h-60 overflow-y-auto">
                    <div class="flex flex-lign items-center mb-2">
                        <input type="text" name="title" placeholder="Titre du post" class="title-input border border-[#b2a5ff] rounded-md font-bold text-xl">
                        <img src="/html/images/trash-can-solid.svg" alt="trashCan" class="trashCan w-4 h-auto transition-transform duration-300 hover:scale-125 ml-auto">
                    </div>
                    <textarea name="content" placeholder="Écrivez votre contenu ici" class="content-input w-full break-words p-2 border border-[#b2a5ff] rounded-md"></textarea>
                    <div class="imageContainer mt-4">
                        <button type="button" class="plusImgButton w-4 h-auto transform transition-transform duration-300 hover:scale-125">
                            <img src="/html/images/plus-solid.svg" alt="plus">
                        </button>
                            <!-- Input de type "file" caché -->
                            <input type="file" id="fileInput" name="fileInput" class="fileInput" accept="image/*"  style="display: none">
                            <p id="fileUploadName"></p>
                    </div>
                    <div class="galleryContainer mt-4"></div>
                    <table class="w-full">
                        <tr>
                            <td>
                                <?php include '../GFramework/searchBar/onlyTopicSearchBar.php'?>
                                <button type="button" class="add-category-button bg-[#b2a5ff] text-white rounded-md px-2 py-1 m-2">Ajouter Catégorie</button>
                            </td>
                            <td id="categoryList" class="justify-content">
                            </td>
                        </tr>
                    </table>
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
                if (empty($_FILES['img'])){
                    $_FILES['img'] = null;
                }
                if (empty ($_POST['topics'])) {
                    $_POST['topics'] = null;
                }
                $postID = $this->publishPost($_POST['title'], $_POST['content'], $_POST['topics']);
                if ( isset($_FILES['fileInput'])) {
                    if ($_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
                        $fileName = $_FILES['fileInput']['name'];
                        $image_source = file_get_contents($_FILES['fileInput']['tmp_name']);
                        $this->dbPostMedia->addAnImageToPost($postID, $this->uploadImage($fileName, $image_source));
                    }
                }
                header('Location: affichagePostDetails.php?detailsPost=' . $postID);
                die();
            }
        }
    }

    public function uploadImage($fileName, $image_source) : string|null {
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