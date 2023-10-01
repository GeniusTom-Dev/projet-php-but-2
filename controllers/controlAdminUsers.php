<?php

namespace controllers;
use \utilities\GReturn;
use \utilities\CannotDoException;
use dbUsers;

class controlAdminUsers
{
    private dbUsers $dbUsers;

    public function __construct($conn){
        $this->dbUsers = new dbUsers($conn);
    }

    /**
     * Verifies if an activation or deactivation form was sent through the method "POST" and realize the necessary
     * SQL request to modify the activation status by using the id stored in the associated $_POST field.
     * @throws CannotDoException If, for some reason, the action cannot be done on the wanted user, throws an Exception to give a report on the reason and be processed.
     */
    public function checkActivationDeactivationUser() : void {
        if (isset($_POST['deactivate'])){
            $id = $_POST['deactivate'];
            if ($id == $_SESSION['user']) {
                $target = 'User -> ' . $id;
                $action = 'Deactivation';
                $explain = 'User cannot deactivate their own account here';
                throw new CannotDoException($target, $action, $explain);
            }
            $this->dbUsers->deactivateUser($id);
        }
        else if (isset($_POST['activate'])){
            $id = $_POST['activate'];
            if ($id == $_SESSION['user']) {
                $target = 'User -> ' . $id;
                $action = 'Activation';
                $explain = 'User cannot reactivate their own account here';
                throw new CannotDoException($target, $action, $explain);
            }
            $this->dbUsers->activateUser($id);
        }
    }

    /**
     * Verifies if a deletion form was sent through the method "POST" and realize the necessary
     * SQL request to delete the user by using the id stored in the associated $_POST field.
     * @throws CannotDoException If, for some reason, the user cannot be deleted, throws an Exception to be processed and give a report on the reason.
     */
    public function checkDeletedUser(): void{
        if (isset($_POST['Delete'])){
            $id = $_POST['Delete'];
            if ($id == $_SESSION['user']) {
                $target = 'User -> ' . $id;
                $action = 'Deletion';
                $explain = 'User cannot delete themselves';
                throw new CannotDoException($target, $action, $explain);
            }
            if ($this->dbUsers->select_SQLResult($id)->getContent()->fetch_assoc()['IS_ADMIN'] == 1){
                $target = 'User -> ' . $id;
                $action = 'Deletion';
                $explain = 'Admin User cannot delete other admins';
                throw new CannotDoException($target, $action, $explain);
            }
            $this->dbUsers->deleteUser($id);
        }
    }

    public function getTableStart(): string{
        ob_start(); ?>
        <table border="1">
            <tr aria-colspan="5">
                <td>Username</td>
                <td>Biographie</td>
                <td>Première connection</td>
                <td>Admin</td>
                <td>Désactiver / Activer</td>
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
        $result = $this->dbUsers->select_SQLResult()->getContent();
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
                <td> <?= $row['USERNAME']?></td>
                <td> <?= $row['USER_BIO']?></td>
                <td> <?= $row['USER_CREATED']?></td>
                <td> <?= $row['IS_ADMIN']?></td>
                <td><form method="post" action="/projet-php-but-2/homeAdmin.php"><button name="<?php
                        if ($row['IS_ACTIVATED'] == 1){
                            echo 'deactivate';
                        }
                        else{
                            echo 'activate';
                        }
                        ?>" value="<?=$row['USERNAME']?>" onclick="submit()">
                            <?php
                            if ($row['IS_ACTIVATED'] == 1){
                                echo 'Désactiver';
                            }
                            else{
                                echo 'Activer';
                            }
                            ?></button></form>
                </td>
                <td><form method="post" action="/projet-php-but-2/homeAdmin.php"><button name="Delete" value="<?=$row['USERNAME']?>" onclick="submit()">X</button></form></td>
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