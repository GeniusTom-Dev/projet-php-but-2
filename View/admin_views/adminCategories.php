<h1>Categories</h1>
<?php

use controllers\controlAdminTopics;

require_once __DIR__ . '/../../GFramework/searchBar/searchBarAdmin.php';
require_once __DIR__ . '/organisersElements.php';
require __DIR__ . '/../../autoloads/adminAutoloader.php';
$controller = new controlAdminTopics($dbConn);

?>
<form id="newCate" method="post">
    <label for="newCateNameId">Nom de la Nouvelle catégorie : </label>
    <input type="text" id="newCateNameId" name="newCateName"><br>
    <label for="newCateInfoId">Description de la catégorie : </label>
    <input type="text" id="newCateInfoId" name="newCateInfo">
    <button onclick="submit()">+</button>
</form>
<?php
$controller->checkNewTopic();
$controller->checkChangedTopic();
$controller->checkDeletedTopic();

?>

    <table>
        <tr>
            <td>Identifiant</td>
            <td>Catégorie</td>
            <td>Description</td>
            <td>Modifier</td>
            <td>Supprimer</td>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>

<?= $controller->getPageInterface() ?>