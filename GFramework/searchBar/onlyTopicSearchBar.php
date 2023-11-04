<?php require_once __DIR__ .'/../autoloader.php';
$db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd');
$dbConn = $db->getConnection()->getContent();
$dbTopics = new DbTopics($dbConn);

?>

<input type="text" name="searchInputTopic" id='searchInputTopic' placeholder="Cliquez pour rechercher..." autocomplete="off" class="categoryInput border border-[#b2a5ff] rounded-md"
    <?php if (isset($_GET['searchInputTopic'])) echo ' value=', $_GET['searchInputTopic']; ?>>
<ul id='topicsList' class="hidden absolute border border-gray-300 max-h-24 overflow-y-auto w-28 p-0 list-none mt-2 bg-white">
    <?php
    foreach ($dbTopics->select_SQLResult()->getContent() as $topic) { ?>
        <li> <?php echo $topic['NAME'] ?></li>
    <?php } ?>
</ul>
<script>
    const searchInput = document.getElementById('searchInputTopic');
    const topicsList = document.getElementById('topicsList');
    const optionItems = topicsList.getElementsByTagName('li');

    // sert à placer la liste en dessous de l'input
    const inputRect = searchInput.getBoundingClientRect();
    topicsList.style.left = inputRect.left + 'px';
    topicsList.style.top = (inputRect.bottom + window.scrollY) + 'px';

    // Ajouter un gestionnaire d'événements au clic sur les options
    for (let i = 0; i < optionItems.length; i++) {
        optionItems[i].addEventListener('click', () => {

            // C'EST ICI POUR RECUP LA CATÉGORIE QUI A ÉTÉ SELECTIONNÉ

            searchInput.value = optionItems[i].textContent.trim();
            topicsList.style.display = 'none';
        });
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

    // Fermer la liste d'options lorsque l'utilisateur clique en dehors
    document.addEventListener('click', (event) => {
        if (event.target !== searchInput && event.target !== topicsList) {
            topicsList.style.display = 'none';
        }
    });
</script>
