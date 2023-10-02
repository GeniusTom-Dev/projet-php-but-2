<?php

namespace controllers;
use \utilities\GReturn;
use \utilities\CannotDoException;
use DbComments;

class controlAdminComments
{

    private DbComments $dbComments;

    public function __construct($conn){
        $this->dbComments = new DbComments($conn);
    }

    /**
     * Verifies if a deletion form was sent through the method "POST" and realize the necessary
     * SQL request to delete the post by using the id stored in the associated $_POST field.
    //     * @throws CannotDoException If, for some reason, the post cannot be deleted, throws an Exception to be processed and give a report on the reason.
     */
    public function checkDeletedComment(): void{
        if (isset($_POST['Delete'])){
            $id = $_POST['Delete'];
            $this->dbComments->deleteComment($id);
        }
    }

    public function getTableStart(): string{
        ob_start(); ?>
        <table border="1">
            <tr aria-colspan="6">
                <td>Identifiant</td>
                <td>Contenu</td>
                <td>Date de création</td>
                <td>Post</td>
                <td>Utilisateur</td>
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
        $result = $this->dbComments->select_SQLResult()->getContent();
        if (!$result)
        {
            echo 'Impossible d\'exécuter la requête...';
        }
        else
        {
            if ($result->num_rows != 0)
            {
                while ($row = $result->fetch_assoc())
                { ?>
            <tr>
                <td><?= $row['COMMENT_ID']?></td>
                <td><?= $row['CONTENT']?></td>
                <td><?= $row['DATE_POSTED']?></td>
                <td><?= $row['POST_ID']?></td>
                <td><?= $row['USER_ID']?></td>
                <td><form method="post" action="/projet-php-but-2/View/homeAdmin.php"><button name="Delete" value="<?=$row['COMMENT_ID']?>" onclick="submit()">X</button></form></td>
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