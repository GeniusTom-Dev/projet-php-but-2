<?php
require_once '../autoloader.php';

$results = [];

if ($_GET["selectDb"] == "Topics") {
    if ($_GET['searchId'] != 0) {
        $results = [$dbTopics->selectById($_GET["searchId"])->getContent()];
    } else {
        $nameOrDescriptionLike = $_GET['searchText'];
        $results = $dbTopics->select_SQLResult($nameOrDescriptionLike)->getContent();
    }
} else if ($_GET["selectDb"] == "Users") {
    if ($_GET['searchId'] != 0) {
        $results = [$dbUsers->selectById($_GET['searchId'])->getContent()];
    } else {
        $usernameLike = $_GET['searchText'];
        $isAdmin = $_GET['searchIsAdmin'];
        $isActivate = $_GET['serachIsActivate'];
        $results = $dbUsers->select_SQLResult($usernameLike, $isAdmin, $isActivate)->getContent();
    }
} else if ($_GET["selectDb"] == "Posts") {
    $results = $dbPosts->select_SQLResult(null, null, null, null)->getContent();
} else if ($_GET["selectDb"] == "Comments") {
    $results = $dbComments->select_SQLResult(null, null, null, null, null)->getContent();
}
?>
    <script>
        var results = <?php echo json_encode($results);?>;
        localStorage.setItem("searchResults", JSON.stringify(results));
    </script>
<?php
include('index.php');
?>