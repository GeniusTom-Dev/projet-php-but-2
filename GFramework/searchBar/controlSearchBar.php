<?php
require_once '../autoloader.php';

$results = [];

if ($_GET["selectDb"] == "Topics") {
    if (isset($_GET['searchId']) && $_GET['searchId'] != 0 && $_GET['searchId'] != '') {
        $results = [$dbTopics->selectById($_GET["searchId"])->getContent()];
    } else {
        if (isset($_GET['searchText'])){
            $nameOrDescriptionLike = $_GET['searchText'];
        }
        else{
            $nameOrDescriptionLike = null;
        }
        $results = $dbTopics->select_SQLResult($nameOrDescriptionLike)->getContent();
    }
} else if ($_GET["selectDb"] == "Users") {
    if (isset($_GET['searchId']) && $_GET['searchId'] != 0 && $_GET['searchId'] != '') {
        $results = [$dbUsers->selectById($_GET['searchId'])->getContent()];
    } else {
        if (isset($_GET['searchText'])){
            $usernameLike = $_GET['searchText'];
        }
        else {
            $usernameLike = null;
        }
        if (isset($_GET['searchIsAdmin'])){
            $isAdmin = $_GET['searchIsAdmin'];
        }
        else {
            $isAdmin = null;
        }
        if (isset($_GET['serachIsActivate'])){
            $isActivate = $_GET['serachIsActivate'];
        }
        else {
            $isActivate = null;
        }

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
echo 'ControlSearchBar    ';?>