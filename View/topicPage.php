<?php
session_start();
require_once "../GFramework/autoloader.php";

//if(!isset($_SESSION['suid']) || !$dbUsers->selectById($_SESSION['suid'])->getContent()['IS_ADMIN']){
//    $_SESSION['isAdmin'] = false;
//}
//else{
//    $_SESSION['isAdmin'] = true;
//}

$_SESSION['suid'] = 2;
$_SESSION['isAdmin'] = true;
$limitNbPosts = 10;

// Restore page or save
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}
else {
    if (!isset($_SESSION['page'])){
        $_SESSION['page'] = 1;
    }
    $_GET['page'] = $_SESSION['page'];
}
// Restore selected topic or save
if (isset($_GET['name'])) {
    $_SESSION['topicName'] = $_GET['name'];
}
else {
    if (!isset($_SESSION['topicName'])){
        header('Location: homepage.php');
        die();
    }
    $_GET['name'] = $_SESSION['topicName'];
}

$postController = new controlGeneratePosts($dbConn);
$postController->checkAllShowActions();

require_once '../GFramework/utilities/utils.inc.php';
start_page($_GET['name']);

require_once "enTete.php";


?>

<header>

</header>
<div class=" h-screen w-64 fixed left-0">
    <?php require_once "navbarTailswind.php";?>
</div>
<section class="h-screen w-full center flex flex-col  items-center">
    <?php // Bouton page précédente
    if ($_GET['page'] > 1){ ?>
        <div>
            <form method="get">
                <button name="page" value="<?= $_GET['page'] - 1 ?>">Page précédente</button>
            </form>
        </div>
    <?php }

    // Affichage répétitif des posts
    $posts = $dbPosts->select_SQLResult($dbTopics->selectByName($_GET['name'])->getContent()['TOPIC_ID'], null, null, null, null, $limitNbPosts, $_GET['page'], 'recent')->getContent();
    foreach ($posts as $post){
        echo $postController->getPostHTML($post['POST_ID']);
        echo PHP_EOL;
    }

    // Bouton page suivante
    $max = count($posts);
    if ($max%$limitNbPosts != 0){
        $max = (int)($max / $limitNbPosts) + 1;
    }
    else{
        $max = (int)($max / $limitNbPosts);
    }
    if ($_GET['page'] < $max){ ?>
        <div>
            <form method="get">
                <button name="page" value="<?= $_GET['page'] + 1 ?>">Page suivante</button>
            </form>
        </div>
    <?php } ?>
    <script src="/projet-php-but-2/html/script/scriptShowPost.js"></script>
</section>

</body>
</html>