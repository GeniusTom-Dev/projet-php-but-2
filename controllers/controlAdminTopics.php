<?php

namespace controllers;
use \utilities\GReturn;
use dbTopics;

class controlAdminTopics
{
    private dbTopics $dbTopics;

    public function __construct($conn){
        $this->dbTopics = new dbTopics($conn);
    }

    public function checkNewTopic(){
        if (isset($_POST['newCateName'])) {
            $cateName = $_POST['newCateName'];
            if (isset($_POST['newCateInfo'])){
                $cateInfo = $_POST['newCateInfo'];
                $this->dbTopics->addTopic($cateName, $cateInfo);
            }
            else{
                $this->dbTopics->addTopic($cateName, '');
            }
        }
    }

    public function checkChangedTopic(){
        if (isset($_POST['Change'])){
            $id = $_POST['Change'];
            $this->dbTopics->changeTopic($id, $_POST['newName'], $_POST['newInfo']);
        }
    }

    public function checkDeletedTopic(){
        if (isset($_POST['Delete'])){
            $id = $_POST['Delete'];
            $this->dbTopics->deleteTopic($id);
        }
    }

    public function getTableStart(): string{
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

    public function getTableContent(): string{
        $result = $this->dbTopics->select_SQLResult()->getContent();
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
            <td> <?= $row['NAME']?></td>
            <td> <?= $row['INFO']?></td>
            <td>
                <form method="post" action="/projet-php-but-2/homeAdmin.php">
                    <button name="Change" value="<?=$row['ID']?>" onclick="submit()">Modif</button>
                    <label for="newName">Nouveau Nom : </label>
                    <input type="text" id="newName" name="newName"><br>
                    <label for="newInfo">Description de la catégorie : </label>
                    <input type="text" id="newInfo" name="newInfo">
                </form>
            </td>
            <td><form method="post" action="/projet-php-but-2/homeAdmin.php"><button name="Delete" value="<?=$row['ID']?>" onclick="submit()">X</button></form></td>
        </tr>
                <?php }
            }
        }
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

    public function showTableFull(): void{
        echo $this->getTableStart();
        echo $this->getTableContent();
        echo $this->getTableEnd();
    }

}