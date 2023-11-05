<?php

namespace controllers;
use DbPosts;

class controlAdminPosts
{
    private DbPosts $dbPosts;
    private int $limitSelect = 10;
    public function __construct($conn){
        $this->dbPosts = new DbPosts($conn);
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
            $results = [$this->dbPosts->selectById($_GET["searchId"])->getContent()];
            $count = count($results); // Result has either 1 or 0 rows no matter the limit
        } else {
            $contentOrTitleLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
            $user_id = (empty($_GET['searchUserId']) === false) ? intval($_GET['searchUserId']) : null;
            $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
            $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
            $count = $this->dbPosts->getTotal($contentOrTitleLike, $user_id, $dateMin, $dateMax);
            $results = $this->dbPosts->select_SQLResult(null, $contentOrTitleLike, $user_id, $dateMin, $dateMax, $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent();
        }
        $container['queryResult'] = $results;
        $container['total'] = $count;
        return $container;
    }

    /* *********************************************************** *
     * ************************* CHECKS ************************** *
     * *********************************************************** */

    /**
     * Verifies if a deletion form was sent through the method "POST" and realize the necessary
     * SQL request to delete the post by using the id stored in the associated $_POST field.
     */
    public function checkDeletedPost(): void{
        if (isset($_POST['Delete'])){
            $id = $_POST['Delete'];
            $this->dbPosts->deletePost($id);
        }
    }

    /* *********************************************************** *
     * ******************* TABLE INTERFACE *********************** *
     * *********************************************************** */

    /**
     * Create table rows that will fill an already existing post table with 5 columns.<br>
     * Each row contains a cell for :
     * <ul>
     *      <li>The post ID</li>
     *      <li>The full content of the post (Title + content)</li>
     *      <li>The ID of the user who made the post</li>
     *      <li>The date the post was created</li>
     *      <li>A button to delete the post (form)</li>
     * </ul>
     * @return string The HTML Code corresponding to the content of the post table
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
                foreach ($result as $row)
                { ?>
            <tr class="border border-gray-200">
                <td class="border border-gray-200" rowspan="2"><?= $row['POST_ID']?></td>
                <td class="border border-gray-200"><?= $row['TITLE']?></td>
                <td class="border border-gray-200" rowspan="2"><?= $row['USER_ID']?></td>
                <td class="border border-gray-200" rowspan="2"><?= $row['DATE_POSTED']?></td>
                <td class="border border-gray-200" rowspan="2"><form method="post"><button name="Delete" value="<?=$row['POST_ID']?>" onclick="submit()">X</button></form></td>
            </tr>
            <tr class="border border-gray-200">
                <td class="border border-gray-200"><?= $row['CONTENT']?></td>
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
        <form method="get">
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