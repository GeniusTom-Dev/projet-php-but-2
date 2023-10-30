<!-- UTLISÉ POUR TESTER, A ADAPTER PAR LA SUITE -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Barre de recherche</h1>
<?php include 'searchBar.php' ?>
<h2>Resultats de la recherche :</h2>
<ul>
    <table>
        <thead>
        <tr id="tableHead">
        </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
    <script src="SQLResultToTable.js"></script>
</ul>
</body>
</html>