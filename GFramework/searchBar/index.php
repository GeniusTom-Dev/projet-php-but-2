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
    <table id="table">
    </table>
    <script src="SQLResultToTable.js"></script>
    <script>
        let selectedDb = <?php echo (isset($_GET['selectDb'])) ? "'" . $_GET['selectDb'] . "'" : "'Topics'"; ?>;
        generateTable(selectedDb, document.getElementById("table"));
    </script>
</ul>
</body>
</html>