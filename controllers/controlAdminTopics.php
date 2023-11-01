<?php

namespace controllers;

use DbTopics;
use GFramework\utilities\GReturn;

class controlAdminTopics
{
    private DbTopics $dbTopics;
    private int $limitSelect = 5;

    public function __construct($conn)
    {
        $this->dbTopics = new DbTopics($conn);
    }

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

    public function checkChangedTopic(): void
    {
        if (isset($_POST['Change'])) {
            $id = $_POST['Change'];
            $this->dbTopics->changeTopic($id, $_POST['newName'], $_POST['newInfo']);
        }
    }

    public function checkDeletedTopic(): void
    {
        if (isset($_POST['Delete'])) {
            $id = $_POST['Delete'];
            $this->dbTopics->deleteTopic($id);
        }
    }

    public function getPageInterface(): string
    {
        $max = $this->getMaxNumPage();
        ob_start(); ?>
        <form method="get" action="/projet-php-but-2/View/homeAdmin.php">
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

    public function showPageInterface(): void
    {
        echo $this->getPageInterface();
    }

    public function getMaxNumPage(): int
    {
        $total = $this->getSearchResult()['total'];
        $max = (int)floor($total / $this->limitSelect);
        if ($total % $this->limitSelect != 0) {
            $max += 1;
        }
        return $max;
    }

    public function getTableStart(): string
    {
        ob_start(); ?>
        <table border="1">
        <tr aria-colspan="4">
            <td>Catégories</td>
            <td>Description</td>
            <td>Modifier</td>
            <td>Supprimer</td>
        </tr>
        <?php
        $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

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
                foreach ($result as &$row)
                { ?>
                    <tr>
                        <td> <?= $row['NAME']?></td>
                        <td> <?= $row['DESCRIPTION']?></td>
                        <td>
                            <form method="post" action="/projet-php-but-2/View/homeAdmin.php">
                                <button name="Change" value="<?=$row['TOPIC_ID']?>" onclick="submit()">Modif</button>
                                <label for="newName">Nouveau Nom : </label>
                                <input type="text" id="newName" name="newName"><br>
                                <label for="newInfo">Description de la catégorie : </label>
                                <input type="text" id="newInfo" name="newInfo">
                            </form>
                        </td>
                        <td><form method="post" action="/projet-php-but-2/View/homeAdmin.php"><button name="Delete" value="<?=$row['TOPIC_ID']?>" onclick="submit()">X</button></form></td>
                    </tr>
                <?php }
            }
        }
        $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

    public function showTableFull(): void
    {
        echo $this->getTableStart();
        echo $this->getTableContent();
    }

    public function getSearchResult(): array{
        $container = [];
        if (empty($_GET["searchId"]) === false) {
            $results = $this->dbTopics->selectById($_GET["searchId"], $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent();
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


}