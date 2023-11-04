<?php
session_start();
require_once "../GFramework/autoloader.php";

$_SESSION['suid'] = 1;

$controller = new controlCreatePosts($dbConn);
$controller->checkCreatePost();

require_once '../GFramework/utilities/utils.inc.php';
start_page("Créer un Post");

require_once "navbarTailswind.php";
?>

<header>

</header>

<?php

echo $controller->getCreatePost();

?>

<script src="/projet-php-but-2/html/script/scriptCreatePost.js"></script>
</body>
</html>


