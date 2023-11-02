<?php
require_once 'searchBarFilters.php';
?>

<div>
    <form method="GET" id="searchForm">
        <input type="hidden" name="newSearch" value="1">
        <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."
            <?php if (empty($_GET['searchText']) === false) echo 'value="' . $_GET["searchText"] . '"'; ?>>
        <input type="submit" value="Rechercher" id="search">
        <br>
        <div id="searchFilters">
            <?php if (!isset($_GET['tab']) || $_GET['tab'] == "categories") getTopicsFilters(true);
            else if ($_GET['tab'] == "utilisateurs") getUsersFilters(true);
            else if ($_GET['tab'] == "posts") getPostsFilters(true);
            else if ($_GET['tab'] == "commentaires") getCommentsFilters(true); ?>
        </div>
    </form>

</div>


