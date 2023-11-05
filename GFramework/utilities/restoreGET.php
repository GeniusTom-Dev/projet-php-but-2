<?php
function restorePage(){
    // Restore page or save
    if (isset($_GET['page'])) {
        $_SESSION['page'] = $_GET['page'];
    }
    else {
        if (!isset($_SESSION['page'])){
            $_SESSION['page'] = 1;
        }
        $_GET['page'] = $_SESSION['page'];
    }
}

/**
 * Restore GET fields for all search parameters if fields were lost (no new search).
 * If there is a new search, reset page field in GET to 1, clear the previously saved parameters in session and save the new ones depending on the current tab.
 * @return void
 */
function checkSearch(): void{
    if (isset($_GET['newSearch'])){
        // Go back to first page
        $_GET['page'] = 1;
        $_SESSION['tab'] = $_GET['selectDb'];
        // Clear search array in session if exists
        if (isset($_SESSION['search'])){
            unset($_SESSION['search']);
        }
        // Repopulate session array depending on tab
        if ($_GET['selectDb'] == 'Topics') {
            fillSearch('session', SearchParameters::getTopicsSearchParameters());
        }
        else if ($_GET['selectDb'] == 'Users') {
            fillSearch('session', SearchParameters::getUsersSearchParameters());
        }
        else if ($_GET['selectDb'] == 'Posts') {
            fillSearch('session', SearchParameters::getPostsSearchParameters());
        }
        else if ($_GET['selectDb'] == 'Comments') {
            fillSearch('session', SearchParameters::getCommentsSearchParameters());
        }
    }
    else {
        if (isset($_GET['selectDb'])){
            $_SESSION['tab'] = $_GET['selectDb'];
        }
        else {
            if (! isset($_SESSION['tab'])){
                $_SESSION['tab'] = 'Topics';
            }
            $_GET['selectDb'] = $_SESSION['tab'];
        }

        // Repopulate get array depending on tab
        if ($_GET['selectDb'] == 'Topics') {
            fillSearch('get', SearchParameters::getTopicsSearchParameters());
        }
        else if ($_GET['selectDb'] == 'Users') {
            fillSearch('get', SearchParameters::getUsersSearchParameters());
        }
        else if ($_GET['selectDb'] == 'Posts') {
            fillSearch('get', SearchParameters::getPostsSearchParameters());
        }
        else if ($_GET['selectDb'] == 'Comments') {
            fillSearch('get', SearchParameters::getCommentsSearchParameters());
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
function fillSearch(string $nameArrayToFill, array $params): void{
    if ($nameArrayToFill == 'get'){
        foreach ($params as $parameter){
            if (isset($_SESSION['search'][$parameter])) {
                $_GET[$parameter] = $_SESSION['search'][$parameter];
                //echo $_GET[$parameter], '     ';
            }
        }
    }
    else if ($nameArrayToFill == 'session'){
        foreach ($params as $parameter){
            if (isset($_GET[$parameter])) {
                $_SESSION['search'][$parameter] = $_GET[$parameter];
                //echo $_SESSION['search'][$parameter], '     ';
            }
        }
    }
}