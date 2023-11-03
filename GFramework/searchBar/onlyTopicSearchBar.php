<?php require_once '../autoloader.php';
$db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd');
$dbConn = $db->getConnection()->getContent();
$dbTopics = new DbTopics($dbConn);

?>
<!--<!DOCTYPE html> ==> A DECOMMENTER POUR LA VOIR EN LANCANT LE FICHIER
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
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
<body>-->
<input type="text" id='searchInputTopic' placeholder="Cliquez pour rechercher..." autocomplete="off">
<ul id='topicsList'>
    <?php
    foreach ($dbTopics->select_SQLResult()->getContent() as &$topic) { ?>
        <li> <?php echo $topic['NAME'] ?></li>
    <?php } ?>
</ul>
<script>
    const searchInput = document.getElementById('searchInputTopic');
    const topicsList = document.getElementById('topicsList');
    const optionItems = topicsList.getElementsByTagName('li');
    positionTopicsList();

    // Function pour placer la liste en dessous de l'input
    function positionTopicsList() {
        const inputRect = searchInput.getBoundingClientRect();
        topicsList.style.left = inputRect.left + 'px';
        topicsList.style.top = (inputRect.bottom + window.scrollY) + 'px';
    }

    // Gérer l'ouverture de la liste d'options
    searchInput.addEventListener('click', () => {
        topicsList.style.display = 'block';
    });

    // Gérer la recherche et la mise à jour de la liste d'options
    searchInput.addEventListener('input', () => {
        const searchText = searchInput.value.toLowerCase();

        for (let i = 0; i < optionItems.length; i++) {
            const option = optionItems[i].textContent.toLowerCase();

            if (option.includes(searchText)) {
                optionItems[i].style.display = 'block';
            } else {
                optionItems[i].style.display = 'none';
            }
        }
    });

    // Ajouter un gestionnaire d'événements au clic sur les options
    for (let i = 0; i < optionItems.length; i++) {
        optionItems[i].addEventListener('click', () => {

            // C'EST ICI POUR RECUP LA CATÉGORIE QUI A ÉTÉ SELECTIONNÉ

            searchInput.value = optionItems[i].textContent;
            topicsList.style.display = 'none';
        });
    }

    // Fermer la liste d'options lorsque l'utilisateur clique en dehors
    document.addEventListener('click', (event) => {
        if (event.target !== searchInput && event.target !== topicsList) {
            topicsList.style.display = 'none';
        }
    });
    console.log("ok")
</script>
</body>
</html>