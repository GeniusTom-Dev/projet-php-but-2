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

// Récupération de la page actuelle:
$page = $_GET['page'] ?? '';
$id = $_GET['id'] ?? '';

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();

switch ($page){
    case 'login':
        $login = $_POST['login'] ?? "";
        $password = $_POST['password'] ?? "";
        if(empty($login) === false && empty($password) === false){
            $result = (new \controllers\AuthController())->checkLogin($dbUsers, $login, $password);
            var_dump($result);
            if($result["result"] === true){
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
        if(empty($email) === false && empty($login) === false && empty($password) === false && empty($passwordConfirm) === false){
            $result = (new \controllers\AuthController())->checkRegister($dbUsers,$email, $login, $password, $passwordConfirm);
            if($result["result"] === true){
                $resultLogin = (new \controllers\AuthController())->checkLogin($dbUsers, $login, $password);
                if($resultLogin["result"] === true){
                    $_SESSION["suid"] = $resultLogin["USER_ID"];
                    $_SESSION["isAdmin"] = $resultLogin["IS_ADMIN"];
                    header("Location: /");
                }
            }
        }


        (new \gui\views\ViewRegister($layout, "Inscription | Echo"))->render();
        break;

    case "logout":
        session_unset();
        session_destroy();
        header("Location: /");
        break;
    default:
//        $view = new \gui\views\View($layout, "Accueil");
        var_dump($_SESSION);
        break;
}