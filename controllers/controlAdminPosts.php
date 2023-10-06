<?php

namespace controllers;
use GFramework\utilities\GReturn;
use \utilities\CannotDoException;
use dbPosts;

class controlAdminPosts
{
    private dbPosts $dbPosts;
    private int $limitSelect = 2;

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
        $result = $this->dbPosts->select_SQLResult(null, null, null, null, null, $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent();
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
                <td rowspan="2"><?= $row['POST_ID']?></td>
                <td><?= $row['TITLE']?></td>
                <td rowspan="2"><?= $row['USER_ID']?></td>
                <td rowspan="2"><?= $row['DATE_POSTED']?></td>
                <td rowspan="2"><form method="post" action="/projet-php-but-2/View/homeAdmin.php"><button name="Delete" value="<?=$row['POST_ID']?>" onclick="submit()">X</button></form></td>
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

    public function getMaxNumPage(): int{
        $total = $this->dbPosts->getTotal();
        $max = (int) floor($total / $this->limitSelect);
        if ($total % $this->limitSelect != 0){
            $max += 1;
        }
        return $max;
    }

    public function getPageInterface(): string{
        $max = $this->getMaxNumPage();
        ob_start(); ?>
        <form method="get" action="/projet-php-but-2/View/homeAdmin.php">
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

    public function showPageInterface(): void{
        echo $this->getPageInterface();
    }

}