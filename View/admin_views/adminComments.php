<h1>Comments</h1>
<?php
require_once '../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require '../autoloads/adminAutoloader.php';
$controller = new \controllers\controlAdminComments($dbConn);
?>

<?php
try{
    $controller->checkDeletedComment();

} catch (\utilities\CannotDoException $e){
    $report = $e->getReport();
    $report = str_replace( '\n', '<br />', $report );
    echo '<p>', $report , '</p>';
}
?>

    <table>
        <tr>
            <td>Identifiant</td>
            <td>Contenu</td>
            <td>Date de création</td>
            <td>Post</td>
            <td>Utilisateur</td>
            <td>Supprimer</td>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>

<?= $controller->getPageInterface() ?>