<?php
//Include
include_once "autoloader.php";
// Init
$layout = new \gui\Layout();


//Init DB
$db = new \GFramework\database\Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd');
$dbConn = $db->getConnection()->getContent();

// Init Class DB
$dbUsers = new \GFramework\database\DbUsers($dbConn);
$dbComments = new \GFramework\database\DbComments($dbConn);
$dbFavorites = new \GFramework\database\DbFavorites($dbConn);
$dbFollows = new \GFramework\database\DbFollows($dbConn);
$dbLikes = new \GFramework\database\DbLikes($dbConn);
$dbPosts = new \GFramework\database\DbPosts($dbConn);
$dbTopics = new \GFramework\database\DbTopics($dbConn);

// Récupération de la page actuelle:
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();

switch ($page) {
    case 'login':
        $login = $_POST['login'] ?? "";
        $password = $_POST['password'] ?? "";
        if (empty($login) === false && empty($password) === false) {
            $result = (new \controllers\AuthController())->checkLogin($dbUsers, $login, $password);
            var_dump($result);
            if ($result["result"] === true) {
                $_SESSION["suid"] = $result["USER_ID"];
                $_SESSION["isAdmin"] = $result["IS_ADMIN"];
                header("Location: /");
            }
        }
        (new \gui\views\ViewLogin($layout, "Connexion | Echo"))->render();
        break;
    case 'register':
        $email = $_POST['email'] ?? "";
        $login = $_POST['login'] ?? "";
        $password = $_POST['password'] ?? "";
        $passwordConfirm = $_POST['passwordConfirm'] ?? "";
        if (empty($email) === false && empty($login) === false && empty($password) === false && empty($passwordConfirm) === false) {
            $result = (new \controllers\AuthController())->checkRegister($dbUsers, $email, $login, $password, $passwordConfirm);
            if ($result["result"] === true) {
                $resultLogin = (new \controllers\AuthController())->checkLogin($dbUsers, $login, $password);
                if ($resultLogin["result"] === true) {
                    $_SESSION["suid"] = $resultLogin["USER_ID"];
                    $_SESSION["isAdmin"] = $resultLogin["IS_ADMIN"];
                    header("Location: /");
                }
            }
        }

        (new \gui\views\ViewRegister($layout, "Inscription | Echo"))->render();
        break;

    case 'search':
        $controller = new controllers\searchResultController();
        (new \gui\views\ViewSearch($layout, "Search | Echo", $controller, $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, $limitRows, $_GET['page'], 'recent'))->render();
    case "logout":
        session_unset();
        session_destroy();
        header("Location: /");
        break;
    default:
        $newSearch = $_GET['newSearch'] ?? "";
        $selectOption = $_GET['selectOption'] ?? "";
        $searchText = $_GET['searchText'] ?? "";
        $isAdmin = $_SESSION["isAdmin"] ?? false;
        if (empty($newSearch) === false || empty($selectOption) === false || empty($searchText) === false) {
            (new \gui\views\ViewHome($layout, "Accueil | Echo", true, array("newSearch" => $newSearch, "selectOption" => $selectOption, "searchText" => $searchText), $isAdmin == true))->render();
        } else {
            (new \gui\views\ViewHome($layout, "Accueil | Echo", true))->render();
        }
        break;
}