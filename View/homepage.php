<?php
session_start();
$_SESSION['suid'] = 2;
$_SESSION['isAdmin'] = true;

require_once "../GFramework/autoloader.php";
require_once '../GFramework/utilities/utils.inc.php';

start_page("Home Page");

require_once "navbarTailswind.php";

