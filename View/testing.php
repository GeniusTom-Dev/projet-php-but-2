<?php
session_start();
$_SESSION['suid'] = 1;
$_SESSION['isAdmin'] = true;

require_once __DIR__ . "/../GFramework/autoloader.php";

$controller = new \controllers\controlUser($dbFollows, $dbUsers);
$controller->checkSubscribe();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!--    <link rel="stylesheet" type="text/css" href="/html/styles/index.css">-->

</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">
<?php
echo $controller->getUserProfileSimple(1);
echo '<br>';
echo $controller->getUserProfileSimple(2);
echo '<br>';
echo $controller->getUserProfileSimple(3);
?>
</body>
</html>
