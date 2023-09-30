<?php

    function checkTab(): void{
        if (isset($_GET['categorie']) || !isset($_SESSION['tab'])) {
            $_SESSION['tab'] = 'Cate';
        }
        else if (isset($_GET['utilisateurs']))
            $_SESSION['tab'] = 'Util';
        else if (isset($_GET['posts']))
            $_SESSION['tab'] = 'Posts';
        else if (isset($_GET['commentaires']))
            $_SESSION['tab'] = 'Comm';
        // else Un onglet est déjà selectionné et pas de nouvelle selection, pas besoin de changer
    }
    function homeReload(): void{
        checkTab();
        if ($_SESSION['tab'] == 'Cate') {
            require 'views/adminCategories.php';
            //echo '<p>Categorie loadée</p>';
        }
        else if ($_SESSION['tab'] == 'Util') {
            require 'views/adminUsers.php';
//            echo '<p>', $_GET['utilisateurs'], '</p>';
        }
        else if ($_SESSION['tab'] == 'Posts') {
            echo '<p>', $_GET['posts'], '</p>';
        }
        else if ($_SESSION['tab'] == 'Comm') {
            echo '<p>', $_GET['commentaires'], '</p>';
        }
        else {
            echo '<p>Rien de selectionné</p>';
        }
    }


?>