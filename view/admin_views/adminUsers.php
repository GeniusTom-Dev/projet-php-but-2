<h1>Utilisateurs</h1>
<?php

use controllers\controlAdminUsers;

require_once __DIR__ . '/../../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require __DIR__ . '/../../autoloads/adminAutoloader.php';
$controller = new controlAdminUsers($dbConn);
?>

<div class="flex flex-col mb-2">
    <div class="mb-4">
        <?php
        try{
            $controller->checkDeletedUser();
            $controller->checkActivationDeactivationUser();
        } catch (\utilities\CannotDoException $e){
            $report = $e->getReport();
            $report = str_replace( '\n', '<br/>', $report );
            echo '<p>', $report , '</p>';
        }
        ?>
    </div>

    <table class="border border-gray-200">
        <tr class="border border-gray-200">
            <th class="border border-gray-200">Identifiant</th>
            <th class="border border-gray-200">Username</th>
            <th class="border border-gray-200">Email</th>
            <th class="border border-gray-200">Biographie</th>
            <th class="border border-gray-200">Première connection</th>
            <th class="border border-gray-200">Dernière connection</th>
            <th class="border border-gray-200">Admin</th>
            <th class="border border-gray-200">Désactiver / Activer</th>
            <th class="border border-gray-200">Supprimer</th>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>
</div>

<?= $controller->getPageInterface() ?>