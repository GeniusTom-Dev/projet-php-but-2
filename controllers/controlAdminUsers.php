<?php

namespace controllers;
use GFramework\utilities\GReturn;
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

    /**
     * Execute a selection query that takes into account the search parameters present in $_GET and the selection limit, page and sort name.
     * Also execute a count query with the same 'where' instruction but without any selection limit.
     * @return array Returns an array containing the result of the search request with limit, page and sort (queryResult), and the total of rows for this request without any selection limit (total).
     */
    public function getSearchResult(): array{
        $container = [];
        if (empty($_GET["searchId"]) === false) {
            $results = [$this->dbUsers->selectById($_GET["searchId"])->getContent()];
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
     * SQL request to delete the user by using the id stored in the associated $_POST field.<br>
     * There exists two cases where the user cannot be deleted on the admin interface:
     * <ol>
     *     <li>The user is trying to delete themselves</li>
     *     <li>The user to be deleted is an admin -> Admins can only be deleted via direct access to the database server</li>
     * </ol>
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

    /**
     * Create table rows that will fill an already existing user table with 9 columns.<br>
     * Each row contains a cell for :
     * <ul>
     *      <li>The user ID</li>
     *      <li>The username</li>
     *      <li>The email</li>
     *      <li>The bio</li>
     *      <li>The date the user created their account</li>
     *      <li>The date the user was last connected</li>
     *      <li>If the user is an admin (1) or not (0)</li>
     *      <li>A button to either activate or deactivate the user's account (form)</li>
     *      <li>A button to delete the user's account (form)</li>
     * </ul>
     * @return string The HTML Code corresponding to the content of the user table
     */
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

    /**
     * Calculate the maximum number of pages possible for the search request using Euclidean division and modulo.
     * The maximum equals to the total of rows from the search request without a limit divided (Euclidean) by the selection limit.<br>
     * In the case where the total of rows is not divisible by the limit, there will be a rest of rows that will never be showed so the int following the maximum is returned instead in this case.
     * @return int The maximum number of pages possible for the search request used in the filling of a table.
     */
    public function getMaxNumPage(): int{
        $total = $this->getSearchResult()['total'];
        $max = (int) floor($total / $this->limitSelect);
        if ($total % $this->limitSelect != 0){
            $max += 1;
        }
        return $max;
    }

    /**
     * Create a page selection interface that allows users to go to :
     * <ul>
     *     <li>The first 3 pages</li>
     *     <li>The page before the current one</li>
     *     <li>The current page</li>
     *     <li>The page after the current one</li>
     *     <li>The last 3 pages</li>
     * </ul>
     * When a button is clicked, the page will be reloaded with the number of the new page.
     * @return string The HTML Code corresponding to the page interface
     */
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