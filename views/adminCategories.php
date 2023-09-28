<h1>Categories</h1>
<?php require_once 'organisersElements.php';
require 'autoloads/adminAutoloader.php';
require_once 'autoloads/database-connect.php';
//require_once 'GFramework/autoloader.php';
//$db = new /*\GFramework\database\*/db('localhost','root','','php-proj');
//$db = $db->getConnection()->getContent();
//echo '<p>', var_dump($dbConn), '</p>';
//$dbTopics = new dbTopics($db);?>
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
//        $dbTopics->addTopic($cateName, $cateInfo);
    }
    else{
//        $dbTopics->addTopic($cateName, '');
    }
//    mysqli_query($conn, $sql);
    
}
if (isset($_POST['Change'])){
    $id = $_POST['Change'];
    if (isset($_POST['newName']) && $_POST['newName'] != ''){
        $newName = $_POST['newName'];
        $sql = "UPDATE topic SET NAME='$newName' WHERE ID='$id'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['newInfo']) && $_POST['newInfo'] != ''){
        $newInfo = $_POST['newInfo'];
        if ($newInfo == 'NULL'){
            $sql = "UPDATE topic SET INFO=NULL WHERE ID='$id'";
        }
        else {
            $sql = "UPDATE topic SET INFO='$newInfo' WHERE ID='$id'";
        }
        mysqli_query($conn, $sql);
    }
}
if (isset($_POST['Delete'])){
    $id = $_POST['Delete'];
    $sql = "DELETE FROM topic WHERE ID='$id'";
    mysqli_query($conn, $sql);
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
