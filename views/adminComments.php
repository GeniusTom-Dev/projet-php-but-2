<h1>Comments</h1>
<?php require_once 'organisersElements.php';
require 'autoloads/adminAutoloader.php';
require_once 'autoloads/database-connect.php';
$controller = new \controllers\controlAdminComments($dbConn)
?>

<?php
try{
    $controller->checkDeletedComment();

} catch (\utilities\CannotDoException $e){
    $report = $e->getReport();
    $report = str_replace( '\n', '<br />', $report );
    echo '<p>', $report , '</p>';
}

$controller->showTableComments();
?>