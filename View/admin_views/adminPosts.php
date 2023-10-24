<h1>Posts</h1>
<?php require_once 'organisersElements.php';
require '../autoloads/adminAutoloader.php';
//require_once 'autoloads/database-connect.php';
$controller = new \controllers\controlAdminPosts($dbConn)
?>

<?php
try{
    $controller->checkDeletedPost();

} catch (\utilities\CannotDoException $e){
    $report = $e->getReport();
    $report = str_replace( '\n', '<br />', $report );
    echo '<p>', $report , '</p>';
}

$controller->showTableFull();

$controller->showPageInterface();

?>