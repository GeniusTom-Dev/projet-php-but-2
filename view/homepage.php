<?php
session_start();
require_once "../GFramework/autoloader.php";

if (!isset($_SESSION['suid']) || !$dbUsers->selectById($_SESSION['suid'])->getContent()['IS_ADMIN']) {
    $_SESSION['isAdmin'] = false;
} else {
    $_SESSION['isAdmin'] = true;
}

if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
} else {
    if (!isset($_SESSION['page'])) {
        $_SESSION['page'] = 1;
    }
    $_GET['page'] = $_SESSION['page'];
}

$postController = new controlGeneratePosts($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
$postController->checkAllShowActions();

require_once '../GFramework/utilities/utils.inc.php';
start_page("Home Page");

require_once "enTete.php";
?>
<div class=" h-screen w-64 fixed left-0">
    <?php require_once "navbarTailswind.php"; ?>
</div>

<section class="h-screen w-1/2 ml-[50%] -translate-x-1/2 flex flex-col  items-center">
    <p class="text-gray-700 text-xl font-semibold mx-4 mt-4 mb-4">Les 5 posts les plus récents : </p>
    <?php
    // Affichage répétitif des posts
    $posts = $dbPosts->select_SQLResult(null, null, null, null, null, 5, 1, 'recent')->getContent();
    foreach ($posts as $post) {
        echo $postController->getPostHTML($post['POST_ID']);
        echo PHP_EOL;
    } ?>
    <script src="/html/script/scriptShowPost.js"></script>
</section>

</body>
</html>