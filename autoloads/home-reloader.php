<?php
    function checkTab(): void{
        if (!isset($_SESSION['tab'])) {
            $_SESSION['tab'] = 'categories';
        }
        if (isset($_GET['tab'])){
            if ($_GET['tab'] != $_SESSION['tab']){
                $_GET['sort'] = 'ID-asc';
            }
            $_SESSION['tab'] = $_GET['tab'];
        }
        else
            $_GET['tab'] = $_SESSION['tab'];
    }

    function checkSort(): void{
        if (!isset($_SESSION['sort'])) {
            $_SESSION['sort'] = 'ID-asc';
        }
        if (isset($_GET['sort']))
            $_SESSION['sort'] = $_GET['sort'];
        else
            $_GET['sort'] = $_SESSION['sort'];
    }

    function homeReload(): void{
        if ($_GET['tab'] == 'categories') {
            require 'admin_views/adminCategories.php';
            //echo '<p>Categorie loadée</p>';
        }
        else if ($_GET['tab'] == 'utilisateurs') {
            require 'admin_views/adminUsers.php';
//            echo '<p>', $_GET['utilisateurs'], '</p>';
        }
        else if ($_GET['tab'] == 'posts') {
            require 'admin_views/adminPosts.php';
//            echo '<p>', $_GET['posts'], '</p>';
        }
        else if ($_GET['tab'] == 'commentaires') {
            require 'admin_views/adminComments.php';
//            echo '<p>', $_GET['commentaires'], '</p>';
        }
        else {
            echo '<p>Rien de selectionné</p>';
        }
    }


?>