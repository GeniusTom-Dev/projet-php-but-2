<?php
require_once '../autoloader.php';
require_once 'controlSearchBar.php';

$results = [];
if (empty($_GET["selectDb"]) === false) {
    var_dump($_GET["selectDb"]);
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
        <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."/>
        <input type="submit" value="Rechercher" id="search"/>
        <br>
        <div id="searchFilters">
            <?php if ($_GET['selectDb'] == "Topics") { ?>
                <label for="searchId">Id = </label>
                <input type="number" id="searchId" name="searchId" min="1" style="width: 50px">
            <?php } else if ($_GET['selectDb'] == "Users") { ?>
                <label for="searchId">Id = </label>
                <input type="number" id="searchId" name="searchId" min="1" style="width: 50px">
                <label for='searchIsAdmin'>Is Activated = </label>
                <input type='checkbox' id='searchIsAdmin'
                       name='searchIsAdmin' <?php if ($_GET["searchIsAdmin"] === "on") echo "checked" ?>>
                <label for='searchIsActivated'>Is Activated = </label>
                <input type='checkbox' id='searchIsActivated'
                       name='searchIsActivated' <?php if ($_GET["searchIsActivated"] === "on") echo "checked" ?>>
            <?php } ?>
        </div>
    </form>
    <script>
        document.getElementById("selectDb").addEventListener("change", function () {
            document.getElementById("searchForm").submit();
        })
    </script>
</div>
