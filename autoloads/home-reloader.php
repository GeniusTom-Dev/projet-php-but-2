<?php
    function checkTab(): void{
        if (!isset($_SESSION['tab'])) {
            $_SESSION['tab'] = 'categories';
        }
        if (isset($_GET['tab']))
            $_SESSION['tab'] = $_GET['tab'];
        else
            $_GET['tab'] = $_SESSION['tab'];
    }

    function homeReload(): void{
        if ($_GET['tab'] == 'categories') {
            require 'views/adminCategories.php';
            //echo '<p>Categorie loadée</p>';
        }
        else if ($_GET['tab'] == 'utilisateurs') {
            require 'views/adminUsers.php';
//            echo '<p>', $_GET['utilisateurs'], '</p>';
        }
        else if ($_GET['tab'] == 'posts') {
            require 'views/adminPosts.php';
//            echo '<p>', $_GET['posts'], '</p>';
        }
        else if ($_GET['tab'] == 'commentaires') {
            require 'views/adminComments.php';
//            echo '<p>', $_GET['commentaires'], '</p>';
        }
        else {
            echo '<p>Rien de selectionné</p>';
        }
    }


?>