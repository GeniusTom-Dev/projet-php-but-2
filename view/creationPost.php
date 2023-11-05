<?php
session_start();
require_once "../GFramework/autoloader.php";

//$_SESSION['suid'] = 10;
//$_SESSION['isAdmin'] = true;

if (empty($_SESSION['suid'])){
    header('Location: homeAdmin.php');
    die();
}

$controller = new controlCreatePosts($dbConn);
$controller->checkCreatePost();

require_once '../GFramework/utilities/utils.inc.php';
start_page("Créer un Post");

require_once "enTete.php";
?>

<div class=" h-screen w-64 fixed left-0">
    <?php require_once "navbarTailswind.php";?>
</div>

<div class="flex">
    <div class="min-h-screen flex-1 flex items-center justify-center ">
<?php

echo $controller->getCreatePost();

?>
    </div>
</div>

<script src="/html/script/scriptCreatePost.js"></script>



