<?php
function start_page($title): void
{
?><!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/Projet/navbar.css"/>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <?php
        }
        ?>
        <?php
        start_page('Pojet');
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