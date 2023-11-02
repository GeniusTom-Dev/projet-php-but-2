<h1>Categories</h1>
<?php
require_once '../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require '../autoloads/adminAutoloader.php';
$controller = new \controllers\controlAdminTopics($dbConn);

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