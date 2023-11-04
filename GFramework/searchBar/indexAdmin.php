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
<?php include 'searchBarAdmin.php' ?>
<h2>Resultats de la recherche :</h2>
<nav>
    <form method="get">
        <ul>
            <li><button name="tab" id="categories" value="categories" onclick="submit()">Catégories</button></li>
            <li><button name="tab" id="utilisateurs" value="utilisateurs" onclick="submit()">Utilisateurs</button></li>
            <li><button name="tab" id="posts" value="posts" onclick="submit()">Posts / Billets</button></li>
            <li><button name="tab" id="commentaires" value="commentaires" onclick="submit()">Commentaires</button></li>
        </ul>
    </form>
</nav>
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