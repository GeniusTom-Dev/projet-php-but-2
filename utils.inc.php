<?php
function start_page($title): void
{
?><!DOCTYPE html>
<html lang="fr" class ="theme-light">
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/Projet/projet-php-but-2/navbar.css"/>
        
    </head>
    <body class = "test">
        <?php
        }
        ?>
        <?php
        start_page('Projet');
        ?>

        <?php
        function end_page($title): void
        {
        ?>
        <body>
            <hr><br><strong><?php echo $title; ?></strong><br><hr>
        <?php
        }
        ?>