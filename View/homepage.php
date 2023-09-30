<?php require '../GFramework/autoloader.php';
$dbUser = new dbUsers($dbConn);
//var_dump($dbUser);
use GFramework\utilities\GReturn; ?>
<?php function displayDBinTable(GReturn $result) {
    $columns = $result->getContent()->fetch_fields();
    $rows = mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC);
    $codeHtml = "<table><tr>";
    foreach ($columns as $aColumn) { // Table Header
        $codeHtml .= "<th style='border: 1px solid black;'>";
        $codeHtml .= $aColumn->name;
        $codeHtml .= "</th>";
    }
    foreach ($rows as $aRow) { // Table Row
        $codeHtml .= "<tr>";
        foreach ($columns as $aColumn) { // Fill the row
            $codeHtml .= "<td style='border: 1px solid black;'>";
            $codeHtml .= $aRow[$aColumn->name];
            $codeHtml .= "</td>";
        }
        $codeHtml .= "</tr>";
    }
    $codeHtml .= "</table>";
    return $codeHtml;
 }?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test du PHP</title>
</head>
<body>
<form action="/rechercher" method="get">
    <input type="text" name="username" placeholder="Rechercher un utilisateur">
    <button type="submit">Rechercher</button>
    <?php
    //echo displayDBinTable($dbUser->select(""));
    //echo displayDBinTable($dbUser->select("admin"));
    var_dump(mysqli_fetch_all($dbUser->select("admin")->getContent(), MYSQLI_ASSOC)[0]);
    $test = array(array("USER_ID" => "0"));
    var_dump($test);
    ?>
</form>
</body>
</html>