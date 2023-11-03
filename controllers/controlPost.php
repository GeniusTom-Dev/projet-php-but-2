<?php
header('Content-Type: application/json');
require_once "../GFramework/autoloader.php";
$controller = new controlShowPosts($dbConn);

$aResult = array();

if( !isset($_POST['functionname']) ) {
    $aResult['error'] = 'No function name!';
}

if( !isset($aResult['error']) ) {

    switch($_POST['functionname']) {
        case 'publishPost':
            if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                $aResult['error'] = 'Error in arguments!';
            }
            else {
                //$controller->publishPost();
            }
            break;

        default:
            $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
            break;
    }

}
echo json_encode($aResult);
?>