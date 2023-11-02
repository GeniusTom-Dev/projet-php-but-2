<?php require_once '../autoloader.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boîte de Dialogue de Recherche</title>
    <style>
        #optionsList {
            display: none;
            position: absolute;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            width: 100px;
            padding: 0;
            list-style: none;
        }
    </style>
</head>
<body>
<h1>Boîte de Dialogue de Recherche</h1>

<input type="text" id="searchInput" placeholder="Cliquez pour rechercher..." autocomplete="off">

<ul id="optionsList">
    <?php
    foreach ($dbTopics->select_SQLResult()->getContent() as &$topic) { ?>
        <li> <?php echo $topic['NAME'] ?></li>
    <?php } ?>
</ul>

<script>
    const searchInput = document.getElementById('searchInput');
    const optionsList = document.getElementById('optionsList');
    const optionItems = optionsList.getElementsByTagName('li');

    // Gérer l'ouverture de la liste d'options
    searchInput.addEventListener('click', () => {
        optionsList.style.display = 'block';
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
            optionsList.style.display = 'none';
        });
    }

    // Fermer la liste d'options lorsque l'utilisateur clique en dehors
    document.addEventListener('click', (event) => {
        if (event.target !== searchInput && event.target !== optionsList) {
            optionsList.style.display = 'none';
        }
    });
</script>
</body>
</html>