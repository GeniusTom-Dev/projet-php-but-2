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
require_once "../GFramework/autoloader.php";

$controller = new controlShowPosts($dbConn);
echo $controller->getFullPostHTML(1);
//echo $controller->getFullPostHTML(22);
?>

<script src="/html/script/scriptShowPost.js"></script>
</body>
</html>


