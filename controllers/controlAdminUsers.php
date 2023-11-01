<?php

namespace controllers;
use \utilities\GReturn;
use \utilities\CannotDoException;
use DbUsers;

class controlAdminUsers
{
    private DbUsers $dbUsers;
    private int $limitSelect = 6;

    public function __construct($conn){
        $this->dbUsers = new DbUsers($conn);
    }

    /* *********************************************************** *
     * ************************* SEARCH ************************** *
     * *********************************************************** */

    public function getSearchResult(): array{
        $container = [];
        if (empty($_GET["searchId"]) === false) {
            $results = [$this->dbUsers->selectById($_GET["searchId"], $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent()];
            $count = count($results); // Result has either 1 or 0 rows no matter the limit
        } else {
            $usernameLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
            $isAdmin = (empty($_GET['searchIsAdmin']) === false) ? $_GET['searchIsAdmin'] : null;
            $isActivate = (empty($_GET['searchIsActivated']) === false) ? $_GET['searchIsActivated'] : null;
            $count = $this->dbUsers->getTotal($usernameLike, $isAdmin, $isActivate);
            $results = $this->dbUsers->select_SQLResult($usernameLike, $isAdmin, $isActivate, $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent();
        }
        $container['queryResult'] = $results;
        $container['total'] = $count;
        return $container;
    }

    /* *********************************************************** *
     * ************************* CHECKS ************************** *
     * *********************************************************** */

    /**
     * Verifies if an activation or deactivation form was sent through the method "POST" and realize the necessary
     * SQL request to modify the activation status by using the id stored in the associated $_POST field.
     * @throws CannotDoException If, for some reason, the action cannot be done on the wanted user, throws an Exception to give a report on the reason and be processed.
     */
    public function checkActivationDeactivationUser() : void {
        if (isset($_POST['deactivate'])){
            $id = $_POST['deactivate'];
            if ($id == $_SESSION['userid']) {
                $target = 'User -> ' . $id;
                $action = 'Deactivation';
                $explain = 'User cannot deactivate their own account here';
                throw new CannotDoException($target, $action, $explain);
            }
            $this->dbUsers->deactivateUser($id);
        }
        else if (isset($_POST['activate'])){
            $id = $_POST['activate'];
            if ($id == $_SESSION['userid']) {
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
            if ($id == $_SESSION['userid']) {
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
            $this->dbUsers->deleteUserByID($id);
        }
    }

    /* *********************************************************** *
     * ******************* TABLE INTERFACE *********************** *
     * *********************************************************** */

    public function getTableContent(): string{
        $result = $this->getSearchResult()['queryResult'];
        if (!$result)
        {
            echo 'Impossible d\'exécuter la requête...';
        }
        else
        {
            if (count($result) != 0)
            {
                ob_start();
               foreach ($result as &$row)
                { ?>
            <tr>
                <td> <?= $row['USER_ID']?></td>
                <td> <?= $row['USERNAME']?></td>
                <td> <?= $row['USER_EMAIL']?></td>
                <td> <?= $row['USER_BIO']?></td>
                <td> <?= $row['USER_CREATED']?></td>
                <td> <?= $row['USER_LAST_CONNECTION']?></td>
                <td> <?= $row['IS_ADMIN']?></td>
                <td><form method="post" action=""><button name="<?php
                        if ($row['IS_ACTIVATED'] == 1){
                            echo 'deactivate';
                        }
                        else{
                            echo 'activate';
                        }
                        ?>" value="<?=$row['USER_ID']?>" onclick="submit()">
                            <?php
                            if ($row['IS_ACTIVATED'] == 1){
                                echo 'Désactiver';
                            }
                            else{
                                echo 'Activer';
                            }
                            ?></button></form>
                </td>
                <td><form method="post" action=""><button name="Delete" value="<?=$row['USER_ID']?>" onclick="submit()">X</button></form></td>
            </tr>
                <?php }
            }
        }
        $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

    /* *********************************************************** *
     * ******************** PAGE SELECT INTERFACE **************** *
     * *********************************************************** */

    public function getMaxNumPage(): int{
        $total = $this->getSearchResult()['total'];
        $max = (int) floor($total / $this->limitSelect);
        if ($total % $this->limitSelect != 0){
            $max += 1;
        }
        return $max;
    }

    public function getPageInterface(): string{
        $max = $this->getMaxNumPage();
        ob_start(); ?>
        <form method="get" action="">
            <table>
                <tr>
                    <td><button name="page" value="1" onclick="submit()">Début</button></td>
                    <td>
                        <?php
                        for ($numPage = 1; $numPage <= $max && $numPage < 4 && $numPage < $_GET['page'] - 1; ++$numPage){
                            ?>
                            <button name="page" value="<?= $numPage ?>" onclick="submit()"><?= $numPage ?></button>
                            <?php
                        }
                        ?>
                    </td>
                    <td>...</td>
                    <td>
                        <?php if ($_GET['page'] - 1 > 0){ ?><button name="page" value="<?= $_GET['page'] - 1 ?>" onclick="submit()"><?= $_GET['page'] - 1?></button><?php } ?>
                        <button name="page" value="<?= $_GET['page']?>" onclick="submit()"><?= $_GET['page']?></button>
                        <?php if ($_GET['page'] + 1 <= $max){ ?><button name="page" value="<?= $_GET['page'] + 1 ?>" onclick="submit()"><?= $_GET['page'] + 1?></button><?php } ?>
                    </td>
                    <td>...</td>
                    <td>
                        <?php
                        for ($numPage = $max - 2; $numPage <= $max; ++$numPage){
                            if ($numPage <= $_GET['page'] + 1) continue;
                            ?>
                            <button name="page" value="<?= $numPage ?>" onclick="submit()"><?= $numPage ?></button>
                            <?php
                        }
                        ?>
                    </td>
                    <td><button name="page" value="<?= $max ?>" onclick="submit()">Fin</button></td>
                </tr>
            </table>
        </form>
        <?php
        $interface = ob_get_contents();
        ob_end_clean();
        return $interface;
    }

}