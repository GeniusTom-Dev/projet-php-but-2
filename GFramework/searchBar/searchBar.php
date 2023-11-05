<?php
require_once '../GFramework/autoloader.php';
if (empty($_GET["selectDb"])) {
    $_GET["selectDb"] = "Topics";
}
require_once 'controlSearchBar.php';
require_once 'searchBarFilters.php';

$results = [];
if (isset($_GET["selectDb"]) === false) {
    if ($_GET["selectDb"] == "Topics") $results = getTopicsResults($dbTopics);
    else if ($_GET["selectDb"] == "Users") $results = getUsersResults($dbUsers);
    else if ($_GET["selectDb"] == "Posts") $results = getPostsResults($dbPosts, $dbTopics);
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

<!--div class="max-w-3xl mx-auto p-4"-->
<form action="search.php" method="GET" id="searchForm" class="space-y-4">
    <input type="hidden" name="newSearch" value="1">
    <div class="flex flex-col mb-2">
        <div class="flex flex-lign items-center mb-2">
            <select id="selectDb" name="selectDb"
                    class="h-8 bg-gray-100 p-2 border border-[#b2a5ff] rounded-md mr-4 pt-1 pb-1">
                <option value="Topics" <?php if ($_GET['selectDb'] == 'Topics') echo 'selected'; ?>>Categories</option>
                <option value="Users" <?php if ($_GET['selectDb'] == 'Users') echo 'selected'; ?>>Utilisateurs</option>
                <option value="Posts" <?php if ($_GET['selectDb'] == 'Posts') echo 'selected'; ?>>Posts</option>
                <option value="Comments" <?php if ($_GET['selectDb'] == 'Comments') echo 'selected'; ?>>Commentaires
            </select>
            <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."
                <?php if (empty($_GET['searchText']) === false) echo 'value="' . $_GET["searchText"] . '"'; ?>
                   class="w-1/3 h-8 bg-gray-100 p-2 border border-[#b2a5ff] rounded-md mr-2"/>
            <input type="submit" value="Rechercher" id="search"
                   class="h-8 pb-1 pt-1 bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700"/>
        </div>
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
<!--/div-->


