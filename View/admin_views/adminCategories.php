<h1>Categories</h1>
<?php
require_once '../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require '../autoloads/adminAutoloader.php';
$controller = new \controllers\controlAdminTopics($dbConn);

?>
<form id="newCate" method="post">
    <label for="newCateName">Nom de la Nouvelle catégorie : </label>
    <input type="text" id="newCateName" name="newCateName"><br>
    <label for="newCateInfo">Description de la catégorie : </label>
    <input type="text" id="newCateInfo" name="newCateInfo">
    <button onclick="submit()">+</button>
</form>
<?php
$controller->checkNewTopic();
$controller->checkChangedTopic();
$controller->checkDeletedTopic();

?>

    <table border="1">
        <tr aria-colspan="5">
            <td>Identifiant</td>
            <td>Catégorie</td>
            <td>Description</td>
            <td>Modifier</td>
            <td>Supprimer</td>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>

<?= $controller->getPageInterface() ?>