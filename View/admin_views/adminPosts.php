<h1>Posts</h1>
<?php
require_once '../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require '../autoloads/adminAutoloader.php';
//require_once 'autoloads/database-connect.php';
$controller = new \controllers\controlAdminPosts($dbConn);
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