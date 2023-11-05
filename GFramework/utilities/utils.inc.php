<?php
function start_page($title): void
{
?><!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?= $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
        <link rel="icon" href="/html/images/favicon.ico" type="image/x-icon">
        <meta charset="UTF-8">
        <meta name="description" content="Description de votre réseau social">
        <meta name="author" content="Mathieu Leroux, Tom Even, Camille Girodengo, Maxime Jauras, Yazid-Raoul Maoulida Attoumani">
        <meta name="keywords" content="réseau social, moderne, post, commentaire, actualité, jeune">
        <meta property="og:title" content="Echo">
        <meta property="og:description" content="Un réseau social pour les jeunes">
        <meta property="og:type" content="website">
    </head>
    <body id="theme-container" style="background-color: white;" class="">
    <!--<body id="theme-container" style="background-color: white;" class="flex justify-center items-center min-h-screen bg-gray-200">-->
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