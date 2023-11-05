<?php
require_once 'GFramework/utilities/';
?>

<div class="flex flex-col items-center mb-8">
    <?php include 'resultsNavigationButtons.php' ?>
    <h2>Resultats de la recherche :</h2>
    <table id="tableResult">
        {results}
        <?php /*whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, $limitRows, $_GET['page'], 'recent'); */ ?>
    </table>
    <?php include 'resultsNavigationButtons.php' ?>
</div>