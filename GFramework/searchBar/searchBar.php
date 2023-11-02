<?php
require_once '../autoloader.php';
require_once 'controlSearchBar.php';
require_once 'searchBarFilters.php';

$results = [];
if (empty($_GET["selectDb"]) === false) {
    if ($_GET["selectDb"] == "Topics") $results = getTopicsResults($dbTopics);
    else if ($_GET["selectDb"] == "Users") $results = getUsersResults($dbUsers);
    else if ($_GET["selectDb"] == "Posts") $results = getPostsResults($dbPosts);
    else if ($_GET["selectDb"] == "Comments") $results = getCommentsResults($dbComments);
} else {
    $results = getTopicsResults($dbTopics);
}
?>
<script>
    var results = <?php echo json_encode($results); ?>;
    localStorage.setItem("searchResults", JSON.stringify(results));
</script>


<div>
    <form action="" method="GET" id="searchForm">
        <select id="selectDb" name="selectDb">
            <option value="Topics" <?php if ($_GET['selectDb'] == 'Topics') echo 'selected'; ?>>Categories</option>
            <option value="Users" <?php if ($_GET['selectDb'] == 'Users') echo 'selected'; ?>>Utilisateurs</option>
            <option value="Posts" <?php if ($_GET['selectDb'] == 'Posts') echo 'selected'; ?>>Posts</option>
            <option value="Comments" <?php if ($_GET['selectDb'] == 'Comments') echo 'selected'; ?>>Commentaires
        </select>
        <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."
            <?php if (empty($_GET['searchText']) === false) echo 'value="' . $_GET["searchText"] . '"'; ?>/>
        <input type="submit" value="Rechercher" id="search"/>
        <br>
        <div id="searchFilters">
            <?php if (!isset($_GET['selectDb']) || $_GET['selectDb'] == "Topics") getTopicsFilters(true);
            else if ($_GET['selectDb'] == "Users") getUsersFilters(true);
            else if ($_GET['selectDb'] == "Posts") getPostsFilters(true);
            else if ($_GET['selectDb'] == "Comments") getCommentsFilters(true); ?>
        </div>
    </form>
    <script>
        document.getElementById("selectDb").addEventListener("change", function () {
            document.getElementById("searchForm").submit();
        })
    </script>
</div>

