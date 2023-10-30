<?php require '../GFramework/autoloader.php';
$dbUsers = new dbUsers($dbConn);

//var_dump($dbUser);
use GFramework\utilities\GReturn; ?>
<?php function displayDBinTable(GReturn $result): string
{
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
} ?>

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
    //echo displayDBinTable($dbUsers->select(""));
    //echo displayDBinTable($dbUsers->select("admin"));
    //var_dump($dbUsers->select_by_id(1)->getContent()["USER_ID"] == 1);
    //var_dump(mysqli_fetch_all($dbUser->select("admin")->getTableContent(), MYSQLI_ASSOC)[0]);
    ?>
</form>
</body>
</html>