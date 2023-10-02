<?php

namespace controllers;
use \utilities\GReturn;
use \utilities\CannotDoException;
use dbPosts;

class controlAdminPosts
{
    private dbPosts $dbPosts;

    public function __construct($conn){
        $this->dbPosts = new dbPosts($conn);
    }

    /**
     * Verifies if a deletion form was sent through the method "POST" and realize the necessary
     * SQL request to delete the post by using the id stored in the associated $_POST field.
//     * @throws CannotDoException If, for some reason, the post cannot be deleted, throws an Exception to be processed and give a report on the reason.
     */
    public function checkDeletedPost(): void{
        if (isset($_POST['Delete'])){
            $id = $_POST['Delete'];
            $this->dbPosts->deletePost($id);
        }
    }

    public function getTableStart(): string{
        ob_start(); ?>
        <table border="1">
            <tr aria-colspan="5">
                <td>Identifiant</td>
                <td>Affichage</td>
                <td>Utilisateur</td>
                <td>Date de création</td>
                <td>Supprimer</td>
            </tr>
        <?php
        $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

    public function getTableEnd(): string{
        ob_start(); ?>
        </table>
        <?php $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

    public function getTableContent(): string{
        $result = $this->dbPosts->select_SQLResult()->getContent();
        if (!$result)
        {
            echo 'Impossible d\'exécuter la requête...';
        }
        else
        {
            if ($result->num_rows != 0)
            {
                ob_start();
                while ($row = $result->fetch_assoc())
                { ?>
            <tr>
                <td rowspan="2"><?= $row['ID']?></td>
                <td><?= $row['TITLE']?></td>
                <td rowspan="2"><?= $row['USER_ID']?></td>
                <td rowspan="2"><?= $row['DATE_POSTED']?></td>
                <td rowspan="2"><form method="post" action="/projet-php-but-2/homeAdmin.php"><button name="Delete" value="<?=$row['ID']?>" onclick="submit()">X</button></form></td>
            </tr>
            <tr>
                <td><?= $row['CONTENT']?></td>
            </tr>
                <?php }
            }
        }
        $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

    public function showTableFull(): void{
        echo $this->getTableStart();
        echo $this->getTableContent();
        echo $this->getTableEnd();
    }
}