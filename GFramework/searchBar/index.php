<!--A SUPPRIMER -->
<?php require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/displaySearchResult.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="test.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #topicsList {
            display: none;
            position: absolute;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            width: 100px;
            padding: 0;
            list-style: none;
            margin-top: 5px;
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-200">

<div class="bg-[#b2a5ff] h-screen w-64 fixed left-0"></div>

<div class="flex flex-col items-center mb-8">
    <?php
    require '../autoloader.php';
    ?>
    <h1>Barre de recherche</h1>
    <?php include 'searchBar.php' ?>

    <h2>Resultats de la recherche :</h2>
    <!--<ul>
    -->
    <table id="table">
        <?php whatToDisplay(); ?>
    </table>
    <!--<script src="SQLResultToTable.js"></script>
        <script>
            let selectedDb = <?php /*echo (isset($_GET['selectDb'])) ? "'" . $_GET['selectDb'] . "'" : "'Topics'"; */ ?>;
            //generateTable(selectedDb, document.getElementById("table"));
        </script>-->
    <!--</ul>-->
</div>

<script src="/html/script/scriptShowPost.js"></script>
</body>
</html>

