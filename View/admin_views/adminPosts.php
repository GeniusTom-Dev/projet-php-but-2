<h1>Posts</h1>
<?php

use controllers\controlAdminPosts;

require_once __DIR__ . '/../../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require __DIR__ . '/../../autoloads/adminAutoloader.php';
$controller = new controlAdminPosts($dbConn);
?>

<?php
try{
    $controller->checkDeletedPost();

} catch (\utilities\CannotDoException $e){
    $report = $e->getReport();
    $report = str_replace( '\n', '<br />', $report );
    echo '<p>', $report , '</p>';
}
?>

    <table>
        <tr>
            <td>Identifiant</td>
            <td>Affichage</td>
            <td>Utilisateur</td>
            <td>Date de création</td>
            <td>Supprimer</td>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>

<?= $controller->getPageInterface() ?>