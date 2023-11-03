<?php
require_once '../autoloader.php';
require_once 'controlSearchBar.php';
require_once 'searchBarFilters.php';

$results = [];
if (empty($_GET["selectDb"]) === false) {
    if ($_GET["selectDb"] == "Topics") $results = getTopicsResults($dbTopics);
    else if ($_GET["selectDb"] == "Users") $results = getUsersResults($dbUsers);
    else if ($_GET["selectDb"] == "Posts") $results = getPostsResults($dbPosts, $dbTopics, $dbUsers);
    else if ($_GET["selectDb"] == "Comments") $results = getCommentsResults($dbComments,$dbUsers);
} else {
    if (isset($_GET['selectDb']) == false) {
        $_GET['selectDb'] = "Posts";
    }
    $results = getTopicsResults($dbTopics);
}
?>
<script>
    var results = <?php echo json_encode($results); ?>;
    localStorage.setItem("searchResults", JSON.stringify(results));
</script>


<div>
    <form method="GET" id="searchForm">
        <select id="selectDb" name="selectDb">
            <option value="Topics" <?php if ($_GET['selectDb'] === 'Topics') echo 'selected'; ?>>Categories</option>
            <option value="Users" <?php if ($_GET['selectDb'] === 'Users') echo 'selected'; ?>>Utilisateurs</option>
            <option value="Posts" <?php if ($_GET['selectDb'] === 'Posts') echo 'selected'; ?>>Posts</option>
            <option value="Comments" <?php if ($_GET['selectDb'] === 'Comments') echo 'selected'; ?>>Commentaires
        </select>
        <script>
            document.getElementById("selectDb").addEventListener("change", function () {
                document.getElementById("searchForm").submit();
            })
        </script>
        <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."
            <?php if (empty($_GET['searchText']) === false) echo 'value="' . $_GET["searchText"] . '"'; ?>/>
        <input type="submit" value="Rechercher" id="search"/>
        <br>
        <div id="searchFilters">
            <?php if (!isset($_GET['selectDb']) || $_GET['selectDb'] === "Topics") getTopicsFilters(false);
            else if ($_GET['selectDb'] == "Users") getUsersFilters(false);
            else if ($_GET['selectDb'] == "Posts") getPostsFilters(false);
            else if ($_GET['selectDb'] == "Comments") getCommentsFilters(false); ?>
        </div>
    </form>
</div>


