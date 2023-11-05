<h1>Categories</h1>
<?php

use controllers\controlAdminTopics;

require_once __DIR__ . '/../../GFramework/searchBar/searchBarAdmin.php';
require_once __DIR__ . '/organisersElements.php';
require __DIR__ . '/../../autoloads/adminAutoloader.php';
$controller = new controlAdminTopics($dbConn);

?>

<div class="flex flex-col mb-2">
    <div class="mb-4">
        <form id="newCate" method="post">
            <label for="newCateNameId">Nom de la Nouvelle catégorie : </label>
            <input type="text" id="newCateNameId" name="newCateName" class="border border-gray-300 rounded-md"><br>
            <label for="newCateInfoId">Description de la catégorie : </label>
            <input type="text" id="newCateInfoId" name="newCateInfo" class="border border-gray-300 rounded-md">
            <button onclick="submit()" class="w-10 h-8 pb-1 pt-1 bg-purple-300 text-white p-2 rounded-md hover:bg-purple-400">+</button>
        </form>
        <?php
        $controller->checkNewTopic();
        $controller->checkChangedTopic();
        $controller->checkDeletedTopic();

        ?>
    </div>


    <table class="border border-gray-200">
        <tr class="border border-gray-200">
            <th class="border border-gray-200">Identifiant</th>
            <th class="border border-gray-200">Catégorie</th>
            <th class="border border-gray-200">Description</th>
            <th class="border border-gray-200">Modifier</th>
            <th class="border border-gray-200">Supprimer</th>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>
</div>

<?= $controller->getPageInterface() ?>