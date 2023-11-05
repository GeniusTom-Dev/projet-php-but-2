<?php
session_start();
require_once "../GFramework/autoloader.php";

//$_SESSION['suid'] = 1;
//$_SESSION['isAdmin'] = true;
$limitRows = 10;

checkSearch();
restorePage();

require_once '../GFramework/utilities/utils.inc.php';
start_page("Recherche");

require_once "enTete.php";

require_once "navbarTailswind.php";

require_once '../GFramework/searchBar/displaySearchResult.php';

// Bouton page précédente
if ($_GET['page'] > 1) { ?>
    <div>
        <form method="get">
            <button name="page" value="<?= $_GET['page'] - 1 ?>">Page précédente</button>
        </form>
    </div>
<?php } ?>


<div class="flex flex-col items-center mb-8">
    <h2>Resultats de la recherche :</h2>
    <table id="table">
        <?php whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, $limitRows, $_GET['page'], 'recent'); ?>
    </table>
</div>

<?php
$max = getTotal($dbComments, $dbPosts, $dbTopics, $dbUsers);
if ($max%$limitRows != 0){
    $max = (int)($max / $limitRows) + 1;
}
else{
    $max = (int)($max / $limitRows);
}
//var_dump($max);
//var_dump($_GET['page']);

if ($_GET['page'] < $max) { ?>
    <div>
        <form method="get">
            <button name="page" value="<?= $_GET['page'] + 1 ?>">Page suivante</button>
        </form>
    </div>
<?php } ?>
<script src="../html/script/scriptShowPost.js"></script>


