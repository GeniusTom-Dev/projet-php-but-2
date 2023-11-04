<?php
session_start();
//$_SESSION['suid'] = 1;
//$_SESSION['isAdmin'] = true;

require_once "../GFramework/autoloader.php";

$controller = new controlGenerateFullPosts($dbConn);
$controller->checkPostId();
$controller->checkAllShowActions();

require_once '../GFramework/utilities/utils.inc.php';
start_page("Post Détaillé");


?>

<header>

</header>
<div class=" h-screen w-64 fixed left-0"><?php require_once "navbarTailswind.php";?></div>
<?php

echo $controller->getFullPostHTML($_GET['detailsPost']);

?>

<script src="/projet-php-but-2/html/script/scriptShowPost.js"></script>
</body>
</html>