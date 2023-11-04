<?php
session_start();
$_SESSION['suid'] = 1;

require_once "../GFramework/autoloader.php";

$controller = new controlCreatePosts($dbConn);
$controller->checkCreatePost();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Création de Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="/html/styles/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-[#b2a5ff] h-screen w-64 fixed left-0"></div>

<?php

echo $controller->getCreatePost();

?>

<script src="/html/script/scriptCreatePost.js"></script>
</body>
</html>


