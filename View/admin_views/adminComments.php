<h1>Comments</h1>
<?php

use controllers\controlAdminComments;

require_once __DIR__ . '/../../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require __DIR__ . '/../../autoloads/adminAutoloader.php';
$controller = new controlAdminComments($dbConn);
?>

<div class="flex flex-col mb-2">
    <div class="mb-4">
        <?php
        try{
            $controller->checkDeletedComment();
        } catch (\utilities\CannotDoException $e){
            $report = $e->getReport();
            $report = str_replace( '\n', '<br />', $report );
            echo '<p>', $report , '</p>';
        }
        ?>
    </div>

    <table class="border border-gray-200">
        <tr class="border border-gray-200">
            <th class="border border-gray-200">Identifiant</th>
            <th class="border border-gray-200">Contenu</th>
            <th class="border border-gray-200">Date de création</th>
            <th class="border border-gray-200">Post</th>
            <th class="border border-gray-200">Utilisateur</th>
            <th class="border border-gray-200">Supprimer</th>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>
</div>

<?= $controller->getPageInterface() ?>