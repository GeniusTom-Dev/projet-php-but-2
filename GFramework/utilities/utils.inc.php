<?php
function start_page($title): void
{
?><!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?= $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="/projet-php-but-2/html/styles/navbar.css"/>
<!--        <script src="https://cdn.tailwindcss.com"></script>-->
<!--        <script src="/projet-php-but-2/html/styles/theme.js"></script>-->
    </head>
    <body id="theme-container" style="background-color: white;" class="">
<?php
}

function end_page(): void
{
?>
    </body>
</html>
<?php
}
?>