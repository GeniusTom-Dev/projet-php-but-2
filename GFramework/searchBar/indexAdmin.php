<!--A SUPPRIMER -->

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php
require '../autoloader.php';
?>

<h1 class="text-2xl font-semibold">Barre de recherche</h1>

<div class="flex space-x-4 items-start">
    <?php include 'searchBarAdmin.php' ?>
</div>

<div class="space-y-4">
    <h2 class="text-xl font-semibold">Résultats de la recherche :</h2>

    <nav class="mb-4">
        <form method="get">
            <ul class="flex space-x-4">
                <li>
                    <button name="tab" id="categories" value="categories" onclick="submit()">Catégories</button>
                </li>
                <li>
                    <button name="tab" id="utilisateurs" value="utilisateurs" onclick="submit()">Utilisateurs</button>
                </li>
                <li>
                    <button name="tab" id="posts" value="posts" onclick="submit()">Posts / Billets</button>
                </li>
                <li>
                    <button name="tab" id="commentaires" value="commentaires" onclick="submit()">Commentaires</button>
                </li>
            </ul>
        </form>
    </nav>
</div>
<!--<ul>
    <table id="table">
    </table>
    <script src="SQLResultToTable.js"></script>
    <script>
        let selectedDb = <?php /*echo (isset($_GET['selectDb'])) ? "'" . $_GET['selectDb'] . "'" : "'Topics'"; */ ?>;
        generateTable(selectedDb, document.getElementById("table"));
    </script>
</ul>-->

</body>
</html>
