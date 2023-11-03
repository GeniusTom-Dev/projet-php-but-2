<?php
session_start();
$_SESSION['suid'] = 4;

require_once "../GFramework/autoloader.php";

$controller = new controlGenerateFullPosts($dbConn);
$controller->checkPostId();
$controller->checkAllShowActions();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Post Full</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="/html/styles/index.css">

</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-[#b2a5ff] h-screen w-64 fixed left-0"></div>

<?php

echo $controller->getFullPostHTML($_GET['detailPost']);

?>

<script src="/html/script/scriptShowPostFull.js"></script>
</body>
</html>


