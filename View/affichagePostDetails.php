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

require_once "enTete.php";
?>
<div class=" h-screen w-64 fixed left-0">
    <?php require_once "navbarTailswind.php";?>
</div>

<div class="flex">
    <div class="min-h-screen flex-1 flex items-center justify-center ">
        <?php

        echo $controller->getFullPostHTML($_GET['detailsPost']);

        ?>
    </div>
</div>

<script src="/projet-php-but-2/html/script/scriptShowPost.js"></script>
</body>
</html>