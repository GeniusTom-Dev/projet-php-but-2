<h1>Categories</h1>
<?php require_once 'organisersElements.php';
require 'autoloads/database-connect.php'?>
<!--<form id="newCate" method="post" action="../homeAdmin.php?categorie=Cate"> -->
<form id="newCate" method="post" action="/projet-php-but-2/homeAdmin.php">
    <label for="newCateName">Nom de la Nouvelle catégorie : </label>
    <input type="text" id="newCateName" name="newCateName"><br>
    <label for="newCateInfo">Description de la catégorie : </label>
    <input type="text" id="newCateInfo" name="newCateInfo">
    <button onclick="submit()">+</button>
</form>
<?php
if (isset($_POST['newCateName'])) {
    $nextID = mysqli_query($conn, 'SELECT (MAX(ID) + 1) AS NEWID FROM topic');
    $nextID = mysqli_fetch_assoc($nextID);
    $newCateID = $nextID['NEWID'];
    $cateName = $_POST['newCateName'];
    if (isset($_POST['newCateInfo'])){
        $cateInfo = $_POST['newCateInfo'];
        $sql = "INSERT INTO topic VALUES ($newCateID, '$cateName', '$cateInfo')";
    }
    else{
        $sql = "INSERT INTO topic VALUES ($newCateID, '$cateName', NULL)";
    }
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
        <td></td>
        <td></td>
    </tr>
            <?php }
        }
    }?>
</table>
