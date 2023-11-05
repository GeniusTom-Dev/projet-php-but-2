<?php
/**
 * Restore GET field for tab if field was lost.
 * If field was not lost then compare with saved tab, if they are different then reset page, sort and search fields in GET, in either case save tab right after.
 * @return void
 */
function checkTab(): void{
        if (!isset($_SESSION['sessionAdmin']['tab'])) {
            $_SESSION['sessionAdmin']['tab'] = 'categories';
        }
        if (isset($_GET['tab'])){
            if ($_GET['tab'] != $_SESSION['sessionAdmin']['tab']){
                $_GET['sort'] = 'ID-asc';
                $_GET['page'] = 1;
                unset($_SESSION['sessionAdmin']['search']);
            }
            $_SESSION['sessionAdmin']['tab'] = $_GET['tab'];
        }
        else
            $_GET['tab'] = $_SESSION['sessionAdmin']['tab'];
    }

/**
 * Restore GET field for sort if field was lost.
 * If field was not lost then compare with saved sort, if they are different then reset page field in GET, in either case save sort right after.
 * @return void
 */
function checkSort(): void{
    if (!isset($_SESSION['sessionAdmin']['sort'])) {
        $_SESSION['sessionAdmin']['sort'] = 'ID-asc';
    }
    if (isset($_GET['sort'])) {
        if ($_GET['sort'] != $_SESSION['sessionAdmin']['sort']) {
            $_GET['page'] = 1;
        }
        $_SESSION['sessionAdmin']['sort'] = $_GET['sort'];
    }
    else
        $_GET['sort'] = $_SESSION['sessionAdmin']['sort'];
}

/**
 * Restore GET fields for all search parameters if fields were lost (no new search).
 * If there is a new search, reset page field in GET to 1, clear the previously saved parameters in session and save the new ones depending on the current tab.
 * @return void
 */
function checkSearchAdmin(): void{
    if (isset($_GET['newSearch'])){
        // Go back to first page
        $_GET['page'] = 1;
        // Clear search array in session if exists
        if (isset($_SESSION['sessionAdmin']['search'])){
            unset($_SESSION['sessionAdmin']['search']);
        }
        // Repopulate session array depending on tab
        if ($_GET['tab'] == 'categories') {
            fillSearchAdmin('session', SearchParameters::getTopicsSearchParameters());
        }
        else if ($_GET['tab'] == 'utilisateurs') {
            fillSearchAdmin('session', SearchParameters::getUsersSearchParameters());
        }
        else if ($_GET['tab'] == 'posts') {
            fillSearchAdmin('session', SearchParameters::getPostsSearchParameters());
        }
        else if ($_GET['tab'] == 'commentaires') {
            fillSearchAdmin('session', SearchParameters::getCommentsSearchParameters());
        }
    }
    else {
        // Repopulate get array depending on tab
        if ($_GET['tab'] == 'categories') {
            fillSearchAdmin('get', SearchParameters::getTopicsSearchParameters());
        }
        else if ($_GET['tab'] == 'utilisateurs') {
            fillSearchAdmin('get', SearchParameters::getUsersSearchParameters());
        }
        else if ($_GET['tab'] == 'posts') {
            fillSearchAdmin('get', SearchParameters::getPostsSearchParameters());
        }
        else if ($_GET['tab'] == 'commentaires') {
            fillSearchAdmin('get', SearchParameters::getCommentsSearchParameters());
        }
    }
}

/**
 * Fill a GLOBAL variable (either $_SESSION or $_GET) with all the values in another GLOBAL variable
 * ($_SESSION if filling $_GET, $_GET if filling $_SESSION) associated to the keys contained in an array.
 * @param string $nameArrayToFill Defines if the GLOBAL variable to fill is $_SESSION (session) or $_GET (get)
 * @param array $params The array that contains the name of the keys from a GLOBAL variable whose value are copy-pasted
 * @return void
 */
function fillSearchAdmin(string $nameArrayToFill, array $params): void{
    if ($nameArrayToFill == 'get'){
        foreach ($params as $parameter){
            if (isset($_SESSION['sessionAdmin']['search'][$parameter])) {
                $_GET[$parameter] = $_SESSION['sessionAdmin']['search'][$parameter];
                //echo $_GET[$parameter], '     ';
            }
        }
    }
    else if ($nameArrayToFill == 'session'){
        foreach ($params as $parameter){
            if (isset($_GET[$parameter])) {
                $_SESSION['sessionAdmin']['search'][$parameter] = $_GET[$parameter];
                //echo $_SESSION['sessionAdmin']['search'][$parameter], '     ';
            }
        }
    }
}

/**
 * Restore GET field for page if field was lost.
 * If field was not lost then save new page.
 * @return void
 */
function checkPage(): void{
    if (!isset($_SESSION['sessionAdmin']['page'])){
        $_SESSION['sessionAdmin']['page'] = 1;
    }
    if (isset($_GET['page'])){
        $_SESSION['sessionAdmin']['page'] = $_GET['page'];
    }
    else {
        $_GET['page'] = $_SESSION['sessionAdmin']['page'];
    }
}

/**
 * Load the admin view associated to the current tab.
 * @return void
 */
function homeReload(): void{
    if ($_GET['tab'] == 'categories') {
        require '../view/admin_views/adminCategories.php';
        //echo '<p>Categorie loadée</p>';
    }
    else if ($_GET['tab'] == 'utilisateurs') {
        require '../view/admin_views/adminUsers.php';
//            echo '<p>', $_GET['utilisateurs'], '</p>';
    }
    else if ($_GET['tab'] == 'posts') {
        require '../view/admin_views/adminPosts.php';
//            echo '<p>', $_GET['posts'], '</p>';
    }
    else if ($_GET['tab'] == 'commentaires') {
        require '../view/admin_views/adminComments.php';
//            echo '<p>', $_GET['commentaires'], '</p>';
    }
    else {
        echo '<p>Rien de selectionné</p>';
    }
}
?>