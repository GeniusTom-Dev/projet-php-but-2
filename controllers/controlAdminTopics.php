<?php

namespace controllers;

use DbTopics;

class controlAdminTopics
{
    private DbTopics $dbTopics;
    private int $limitSelect = 5;

    public function __construct($conn)
    {
        $this->dbTopics = new DbTopics($conn);
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
            $results = [$this->dbTopics->selectById($_GET["searchId"])->getContent()];
            $count = count($results); // Result has either 1 or 0 rows no matter the limit
        } else {
            $nameOrDescriptionLike = (empty($_GET["searchText"]) === false) ? $_GET['searchText'] : null;
            $count = $this->dbTopics->getTotal($nameOrDescriptionLike);
            $results = $this->dbTopics->select_SQLResult($nameOrDescriptionLike, $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent();
        }
        $container['queryResult'] = $results;
        $container['total'] = $count;
        return $container;
    }

     /* *********************************************************** *
     * ************************* CHECKS ************************** *
     * *********************************************************** */

    /**
     * Verifies if a topic creation form was sent through the method "POST" and realize the necessary
     *  SQL request to create the new topic by using the name and description stored in the associated $_POST field.
     * @return void
     */
    public function checkNewTopic(): void
    {
        if (isset($_POST['newCateName'])) {
            $cateName = $_POST['newCateName'];
            if (isset($_POST['newCateInfo'])) {
                $cateInfo = $_POST['newCateInfo'];
                $this->dbTopics->addTopic($cateName, $cateInfo);
            } else {
                $this->dbTopics->addTopic($cateName, '');
            }
        }
    }

    /**
     * Verifies if a modification form was sent through the method "POST" and realize the necessary
     * SQL request to modify the name and description by using the id stored in the associated $_POST field.
     * @return void
     */
    public function checkChangedTopic(): void
    {
        if (isset($_POST['Change'])) {
            $id = $_POST['Change'];
            $this->dbTopics->changeTopic($id, $_POST['newName'], $_POST['newInfo']);
        }
    }

    /**
     * Verifies if a deletion form was sent through the method "POST" and realize the necessary
     * SQL request to delete the topic by using the id stored in the associated $_POST field.<br>
     * @return void
     */
    public function checkDeletedTopic(): void
    {
        if (isset($_POST['Delete'])) {
            $id = $_POST['Delete'];
            $this->dbTopics->deleteTopic($id);
        }
    }

    /* *********************************************************** *
     * ******************* TABLE INTERFACE *********************** *
     * *********************************************************** */

    /**
     * Create table rows that will fill an already existing topic table with 5 columns.<br>
     * Each row contains a cell for :
     * <ul>
     *      <li>The topic ID</li>
     *      <li>The name</li>
     *      <li>The description</li>
     *      <li>The modification form (Modif button, text-field for name and description each)</li>
     *      <li>A button to delete the topic (form)</li>
     * </ul>
     * @return string The HTML Code corresponding to the content of the topic table
     */
    public function getTableContent(): string
    {
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
                foreach ($result as $row)
                { ?>
                    <tr>
                        <td> <?= $row['TOPIC_ID']?></td>
                        <td> <?= $row['NAME']?></td>
                        <td> <?= $row['DESCRIPTION']?></td>
                        <td>
                            <form method="post">
                                <button name="Change" value="<?=$row['TOPIC_ID']?>" onclick="submit()">Modif</button><br>
                                <label>Nouveau Nom : </label>
                                <input type="text" name="newName"><br>
                                <label>Description de la catégorie : </label>
                                <input type="text" name="newInfo">
                            </form>
                        </td>
                        <td><form method="post"><button name="Delete" value="<?=$row['TOPIC_ID']?>" onclick="submit()">X</button></form></td>
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
    public function getMaxNumPage(): int
    {
        $total = $this->getSearchResult()['total'];
        $max = (int)floor($total / $this->limitSelect);
        if ($total % $this->limitSelect != 0) {
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
    public function getPageInterface(): string
    {
        $max = $this->getMaxNumPage();
        ob_start(); ?>
        <form method="get">
            <table>
                <tr>
                    <td>
                        <button name="page" value="1" onclick="submit()">Début</button>
                    </td>
                    <td>
                        <?php
                        for ($numPage = 1; $numPage <= $max && $numPage < 4 && $numPage < $_GET['page'] - 1; ++$numPage) {
                            ?>
                            <button name="page" value="<?= $numPage ?>" onclick="submit()"><?= $numPage ?></button>
                            <?php
                        }
                        ?>
                    </td>
                    <td>...</td>
                    <td>
                        <?php if ($_GET['page'] - 1 > 0) { ?>
                            <button name="page" value="<?= $_GET['page'] - 1 ?>"
                                    onclick="submit()"><?= $_GET['page'] - 1 ?></button><?php } ?>
                        <button name="page" value="<?= $_GET['page'] ?>"
                                onclick="submit()"><?= $_GET['page'] ?></button>
                        <?php if ($_GET['page'] + 1 <= $max) { ?>
                            <button name="page" value="<?= $_GET['page'] + 1 ?>"
                                    onclick="submit()"><?= $_GET['page'] + 1 ?></button><?php } ?>
                    </td>
                    <td>...</td>
                    <td>
                        <?php
                        for ($numPage = $max - 2; $numPage <= $max; ++$numPage) {
                            if ($numPage <= $_GET['page'] + 1) continue;
                            ?>
                            <button name="page" value="<?= $numPage ?>" onclick="submit()"><?= $numPage ?></button>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <button name="page" value="<?= $max ?>" onclick="submit()">Fin</button>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        $interface = ob_get_contents();
        ob_end_clean();
        return $interface;
    }

}