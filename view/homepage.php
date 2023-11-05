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

<section class="h-screen w-full flex flex-col  items-center">
    <p class="text-gray-700 text-xl font-semibold mx-4 mt-4 mb-4">Les 5 posts les plus récents : </p>
<?php
    // Affichage répétitif des posts
    $posts = $dbPosts->select_SQLResult(null, null, null, null, null, 5, 1, 'recent')->getContent();
    foreach ($posts as $post) {
        echo $postController->getPostHTML($post['POST_ID']);
        echo PHP_EOL;
    }

    // Bouton page suivante
    $max = $dbPosts->getTotal(null, null, null, null);
    if ($max % $limitNbPosts != 0) {
        $max = (int)($max / $limitNbPosts) + 1;
        echo $max;
    } else {
        $max = (int)($max / $limitNbPosts);
    }?>
    <div class="flex flex-lign items-center mb-4">
        <div>
            <form method="get">
                <button name="page" <?php if ($_GET['page'] == 1) echo "disabled" ?>
    value="<?= $_GET['page'] - 1 ?>"
    class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 mr-2 disabled:bg-gray-500 disabled:cursor-not-allowed">
    Page précédente
    </button>
    </form>
    </div>
    <p class="text-gray-700 text-xl font-semibold mx-4"> Page <?php echo $_GET['page'] . ' ' ?> </p>
    <div>
        <form method="get">
            <button name="page" <?php if ($_GET['page'] == $max) echo "disabled" ?>
                    value="<?= $_GET['page'] + 1 ?>"

                    class="bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 disabled:bg-gray-500 disabled:cursor-not-allowed">
                Page suivante
            </button>
        </form>
    </div>
    </div>
    <script src="/html/script/scriptShowPost.js"></script>
</section>

</body>
</html>