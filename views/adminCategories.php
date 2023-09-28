<h1>Categories</h1>
<?php require_once 'organisersElements.php';
require 'autoloads/adminAutoloader.php';
require_once 'autoloads/database-connect.php';
//echo '<p>', var_dump($dbConn), '</p>';
$dbTopics = new dbTopics($dbConn);?>
<form id="newCate" method="post" action="/projet-php-but-2/homeAdmin.php">
    <label for="newCateName">Nom de la Nouvelle catégorie : </label>
    <input type="text" id="newCateName" name="newCateName"><br>
    <label for="newCateInfo">Description de la catégorie : </label>
    <input type="text" id="newCateInfo" name="newCateInfo">
    <button onclick="submit()">+</button>
</form>
<?php
if (isset($_POST['newCateName'])) {
    $cateName = $_POST['newCateName'];
    if (isset($_POST['newCateInfo'])){
        $cateInfo = $_POST['newCateInfo'];
        $dbTopics->addTopic($cateName, $cateInfo);
    }
    else{
        $dbTopics->addTopic($cateName, '');
    }
}
if (isset($_POST['Change'])){
    $id = $_POST['Change'];
    $dbTopics->changeTopic($id, $_POST['newName'], $_POST['newInfo']);
}
if (isset($_POST['Delete'])){
    $id = $_POST['Delete'];
    $dbTopics->deleteTopic($id);
}
?>

<table border="1">
    <tr aria-colspan="4">
        <td>Catégories</td>
        <td>Description</td>
        <td>Modifier</td>
        <td>Supprimer</td>
    </tr>
    <?php
    $query = 'SELECT * FROM topic ORDER BY ID ASC';
    $result = mysqli_query($conn, $query);
    if (!$result)
    {
        echo 'Impossible d\'exécuter la requête ', $query, ' : ', mysqli_error($conn);
    }
    else
    {
        if (mysqli_num_rows($result) != 0)
        {
            while ($row = mysqli_fetch_assoc($result))
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
    }?>
</table>
