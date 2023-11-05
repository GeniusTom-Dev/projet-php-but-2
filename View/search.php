<?php
session_start();
//$_SESSION['suid'] = 1;
//$_SESSION['isAdmin'] = true;

require_once "../GFramework/autoloader.php";

require_once '../GFramework/utilities/utils.inc.php';
start_page("Recherche");

require_once "enTete.php";

require_once "navbarTailswind.php";

require_once '../GFramework/searchBar/displaySearchResult.php';

?>
<div class="flex flex-col items-center mb-8">
    <h2>Resultats de la recherche :</h2>
       <table id="table">
            <?php whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts,$dbTopics, $dbUsers); ?>
        </table>
</div>
<script src="../html/script/scriptShowPost.js"></script>


