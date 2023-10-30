<?php

namespace controllers;

use DbTopics;
use utilities\GReturn;

class controlAdminTopics
{
    private DbTopics $dbTopics;
    private int $limitSelect = 10;

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
        $total = $this->dbTopics->getTotal();
        $max = (int)floor($total / $this->limitSelect);
        if ($total % $this->limitSelect != 0) {
            $max += 1;
        }
        return $max;
    }

    public function getTableStart(): string
    {
        ob_start(); ?>
        <p id="test">zzzzzzzz</p>
        <table border="1">
            <tr aria-colspan="4">
                <td>Catégories</td>
                <td>Description</td>
                <td>Modifier</td>
                <td>Supprimer</td>
            </tr>
            <tbody id="tableBody"></tbody>
        </table>
        <?php
        $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

    public function getTableContent(): string
    {
        $result = $this->dbTopics->select_SQLResult(null, null, $this->limitSelect, $_GET['page'], $_GET['sort'])->getContent();
        //var_dump($result);
        if (!$result) {
            echo 'Aucun résultat...';
        } else {
            ob_start();
            ?>
            <script>
                var results = <?php echo json_encode($result);?>;
                localStorage.setItem("results", JSON.stringify(results));
                var tableBody = document.getElementById("tableBody");
                var array = JSON.parse(localStorage.getItem("results"));
                var debug = document.getElementById("test");
                for (var line in array) {
                    debug.textContent = array[line]["NAME"];
                    var row = tableBody.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(3);
                    var cell4 = row.insertCell(4);
                    cell1.innerHTML = array[line]["NAME"];
                    cell2.innerHTML = array[line]["DESCRIPTION"];
                    var form1 = document.createElement("form");
                    form1.method = "post";
                    form1.action = "/projet-php-but-2/View/homeAdmin.php";

                    var button1 = document.createElement("button");
                    button1.name = "Change";
                    button1.value = array[line]["TOPIC_ID"];
                    button1.textContent = "Modif";
                    button1.onclick = function () {
                        submit();
                    };

                    var label1 = document.createElement("label");
                    label1.htmlFor = "newName";
                    label1.textContent = "Nouveau Nom : ";

                    var input1 = document.createElement("input");
                    input1.type = "text";
                    input1.id = "newName";
                    input1.name = "newName";

                    var lineBreak1 = document.createElement("br");

                    var label2 = document.createElement("label");
                    label2.htmlFor = "newInfo";
                    label2.textContent = "Description de la catégorie : ";

                    var input2 = document.createElement("input");
                    input2.type = "text";
                    input2.id = "newInfo";
                    input2.name = "newInfo";

                    form1.appendChild(button1);
                    form1.appendChild(label1);
                    form1.appendChild(input1);
                    form1.appendChild(lineBreak1);
                    form1.appendChild(label2);
                    form1.appendChild(input2);

                    cell3.appendChild(form1);

                    var form2 = document.createElement("form");
                    form2.method = "post";
                    form2.action = "/projet-php-but-2/View/homeAdmin.php";

                    var button2 = document.createElement("button");
                    button2.name = "Delete";
                    button2.value = array[line]["TOPIC_ID"];
                    button2.textContent = "X";
                    button2.onclick = function () {
                        submit();
                    };

                    form2.appendChild(button2);

                    cell4.appendChild(form2);
                    /*cell3.innerHTML = `<form method="post" action="/projet-php-but-2/View/homeAdmin.php">
                                        <button name="Change" value="`;
                    cell3.innerHTML += array[line]["TOPIC_ID"];
                    cell3.innerHTML += `" onclick="submit()">Modif</button>
                                        <label for="newName">Nouveau Nom : </label>
                                        <input type="text" id="newName" name="newName"><br>
                                        <label for="newInfo">Description de la catégorie : </label>
                                        <input type="text" id="newInfo" name="newInfo">
                                    </form>`;
                    cell4.innerHTML = `<form method="post" action="/projet-php-but-2/View/homeAdmin.php">
                        <button name="Delete" value="`;
                    cell4.innerHTML += array[line]["DESCRIPTION]";
                    cell4.innerHTML += `onclick="submit()">X</button></form>`;*/
                }
            </script>
        <?php }
        $table = ob_get_contents();
        ob_end_clean();
        return $table;
    }

    public function showTableFull(): void
    {
        echo $this->getTableStart();
        echo $this->getTableContent();
    }
}