<h1>Categories</h1>
<?php
require_once '../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require '../autoloads/adminAutoloader.php';
$controller = new \controllers\controlAdminTopics($dbConn);

?>
<form id="newCate" method="post" action="">
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

$controller->showTableFull();

$controller->showPageInterface();
//echo $controller->getMaxNumPage();

?>