<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200">
<?php
require '../autoloader.php';
?>

<header class="flex flex-lign items-center mb-2 bg-purple-800 p-2">
    <div class="w-100 h-100">
        <img src="/projet-php-but-2/html/images/profile-removebg-preview.png" alt="PP" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
    </div>
    <div class="flex justify-center items-center ml-16">
        <?php include 'searchBar.php' ?>
    </div>
</header>

</body>
</html>
