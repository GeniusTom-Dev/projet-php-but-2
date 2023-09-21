<?php
    function homeReload(): void{
        if (isset($_GET['categorie']))
            echo '<p>', $_GET['categorie'], '</p>';
        else if (isset($_GET['utilisateurs']))
            echo '<p>', $_GET['utilisateurs'], '</p>';
        else if (isset($_GET['posts']))
            echo '<p>', $_GET['posts'], '</p>';
        else if (isset($_GET['commentaires']))
            echo '<p>', $_GET['commentaires'], '</p>';
        else
            echo '<p> Rien de selectionné</p>';
    }
?>