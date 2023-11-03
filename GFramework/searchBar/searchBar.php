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

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-3xl mx-auto p-4">
    <form method="GET" id="searchForm" class="space-y-4">
        <div class="flex items-center space-x-4">
            <select id="selectDb" name="selectDb" class="w-1/4 bg-gray-100 p-2 rounded-m">
                <option value="Topics" <?php if ($_GET['selectDb'] == 'Topics') echo 'selected'; ?>>Categories</option>
                <option value="Users" <?php if ($_GET['selectDb'] == 'Users') echo 'selected'; ?>>Utilisateurs</option>
                <option value="Posts" <?php if ($_GET['selectDb'] == 'Posts') echo 'selected'; ?>>Posts</option>
                <option value="Comments" <?php if ($_GET['selectDb'] == 'Comments') echo 'selected'; ?>>Commentaires
            </select>
            <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."
                <?php if (empty($_GET['searchText']) === false) echo 'value="' . $_GET["searchText"] . '"'; ?>
                   class="w-3/4 bg-gray-100 p-2 rounded-m"/>
        </div>
        <div class="flex items-center justify-between">
            <input type="submit" value="Rechercher" id="search"
                   class="bg-purple-500 text-white p-2 rounded hover:bg-purple-700"/>
            <div id="searchFilters">
                <?php if (!isset($_GET['selectDb']) || $_GET['selectDb'] == "Topics") getTopicsFilters(false);
                else if ($_GET['selectDb'] == "Users") getUsersFilters(false);
                else if ($_GET['selectDb'] == "Posts") getPostsFilters(false);
                else if ($_GET['selectDb'] == "Comments") getCommentsFilters(false); ?>
            </div>
        </div>
    </form>
    <script>
        document.getElementById("selectDb").addEventListener("change", function () {
            document.getElementById("searchForm").submit();
        })
    </script>
</div>


