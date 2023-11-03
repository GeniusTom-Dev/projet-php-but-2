<!DOCTYPE html>
<html>
<head>
    <title>Ma Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="/html/styles/index.css">

</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-[#b2a5ff] h-screen w-64 fixed left-0"></div>

<?php
require_once "../GFramework/autoloader.php";

if (isset($_GET['topics'])){
    foreach ($_GET['topics'] as $topic){
        echo $topic, "    ";
    }
}
else {
    echo 'Pas un array.';
}

$controller = new controlShowPosts($dbConn);
echo $controller->getCreatePost();

?>

<script src="/html/script/scriptCreatePost.js"></script>
</body>
</html>


