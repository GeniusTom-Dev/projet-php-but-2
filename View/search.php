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
        <?php whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, 10, $_GET['page'], 'recent'); ?>
    </table>
</div>

<?php
$max = getTotal($dbComments, $dbPosts, $dbTopics, $dbUsers);
$max = (int)($max / 10 + $max % 10);
var_dump("max = " . $max);

if ($_GET['page'] < $max) { ?>
    <div>
        <form method="get">
            <button name="page" value="<?= $_GET['page'] + 1 ?>">Page suivante</button>
        </form>
    </div>
<?php } ?>
<script src="../html/script/scriptShowPost.js"></script>


