<?php

namespace GFramework\utilities;

use GFramework\database;

class controlAdminComments
{
    private \GFramework\database\DbComments $dbComments;
    private int $limitSelect = 10;

    public function __construct($conn)
    {
        $this->dbComments = new \GFramework\database\DbComments($conn);
    }

    /* *********************************************************** *
     * ************************* SEARCH ************************** *
     * *********************************************************** */

    /**
     * Execute a selection query that takes into account the search parameters present in $_GET and the selection limit, page and sort name.
     * Also execute a count query with the same 'where' instruction but without any selection limit.
     * @return array Returns an array containing the result of the search request with limit, page and sort (queryResult), and the total of rows for this request without any selection limit (total).
     */
    public function getSearchResult(): array
    {
        $container = [];

        $post_id = (empty($_GET['searchPostId']) === false) ? $_GET['searchPostId'] : null;
        $user_id = (empty($_GET['searchUserId']) === false) ? $_GET['searchUserId'] : null;
        $contentLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
        $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
        $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
        $count = $this->dbComments->getTotal($post_id, $user_id, $contentLike, $dateMin, $dateMax);
        $results = $this->dbComments->select_SQLResult($post_id, $user_id, $contentLike, $dateMin, $dateMax, $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent();

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
     * @return void
     */
    public function checkDeletedComment(): void
    {
        if (isset($_POST['Delete'])) {
            $id = $_POST['Delete'];
            $this->dbComments->deleteComment($id);
        }
    }

    /* *********************************************************** *
     * ******************* TABLE INTERFACE *********************** *
     * *********************************************************** */

    /**
     * Create table rows that will fill an already existing comment table with 6 columns.<br>
     * Each row contains a cell for :
     * <ul>
     *      <li>The comment ID</li>
     *      <li>The content of the comment</li>
     *      <li>The date the comment was posted</li>
     *      <li>The ID of the post this comment is linked to</li>
     *      <li>The ID of the user who made this comment</li>
     *      <li>A button to delete the user's account (form)</li>
     * </ul>
     * @return string The HTML Code corresponding to the content of the comment table
     */
    public function getTableContent(): string
    {
        $result = $this->getSearchResult()['queryResult'];
        if (!$result) {
            echo 'Impossible d\'exécuter la requête...';
        } else {
            if (count($result) != 0) {
                ob_start();
                foreach ($result as &$row) { ?>
                    <tr class="border border-gray-200">
                        <td class="border border-gray-200"><?= $row['COMMENT_ID'] ?></td>
                        <td class="border border-gray-200"><?= $row['CONTENT'] ?></td>
                        <td class="border border-gray-200"><?= $row['DATE_POSTED'] ?></td>
                        <td class="border border-gray-200"><?= $row['POST_ID'] ?></td>
                        <td class="border border-gray-200"><?= $row['USER_ID'] ?></td>
                        <td class="border border-gray-200">
                            <form method="post">
                                <button name="Delete" value="<?= $row['COMMENT_ID'] ?>" onclick="submit()">X</button>
                            </form>
                        </td>
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