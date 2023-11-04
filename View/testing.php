<?php
session_start();
$_SESSION['suid'] = 1;
$_SESSION['isAdmin'] = true;

require_once "../GFramework/autoloader.php";

$controller = new \controllers\controlUser($dbConn);

echo $controller->getUserProfileSimple(1);
echo '<br>';
echo $controller->getUserProfileSimple(2);