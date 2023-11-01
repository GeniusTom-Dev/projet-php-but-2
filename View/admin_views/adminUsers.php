<h1>Utilisateurs</h1>
<?php
require_once '../GFramework/searchBar/searchBarAdmin.php';
require_once 'organisersElements.php';
require '../autoloads/adminAutoloader.php';
$controller = new \controllers\controlAdminUsers($dbConn);
?>

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
    <table border="1">
        <tr aria-colspan="9">
            <td>Identifiant</td>
            <td>Username</td>
            <td>Email</td>
            <td>Biographie</td>
            <td>Première connection</td>
            <td>Dernière connection</td>
            <td>Admin</td>
            <td>Désactiver / Activer</td>
            <td>Supprimer</td>
        </tr>
        <?= $controller->getTableContent(); ?>
    </table>

<?= $controller->getPageInterface() ?>