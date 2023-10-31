<!-- UTLISÉ POUR TESTER, A ADAPTER PAR LA SUITE -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
require '../autoloader.php';
?>
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
    <script>
        var selectedDb = <?php echo (isset($_GET['selectDb'])) ? "'" . $_GET['selectDb'] . "'" : "'Topics'"; ?>;
        generateTable(selectedDb, document.getElementById("tableHead"), document.getElementById("tableBody"));
    </script>
</ul>
</body>
</html>