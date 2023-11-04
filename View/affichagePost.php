<?php
session_start();
$_SESSION['suid'] = 1;
$_SESSION['isAdmin'] = true;

require_once "../GFramework/autoloader.php";

$controller = new controlGeneratePosts($dbConn);
$controller->checkAllShowActions();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
<!--    <link rel="stylesheet" type="text/css" href="/html/styles/index.css">-->

</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-[#b2a5ff] h-screen w-64 fixed left-0"></div>

<?php

echo $controller->getPostHTML(1);

?>

<script src="/html/script/scriptShowPost.js"></script>
</body>
</html>


