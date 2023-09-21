<h1>Categories</h1>
<?php require 'organisersElements.php';
require 'autoloads/database-connect.php'?>
<table border="1">
    <tr aria-colspan="4">
        <td>Catégories</td>
        <td>Libellé</td>
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
