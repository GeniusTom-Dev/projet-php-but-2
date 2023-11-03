<?php
require_once 'searchBarFilters.php';
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-lg mx-auto p-4">
    <form method="GET" id="searchForm" class="space-y-4">
        <div class="flex flex-lign items-center mb-2">
            <input type="hidden" name="newSearch" value="1">
            <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."
                <?php if (empty($_GET['searchText']) === false) echo 'value="' . $_GET["searchText"] . '"'
                ?> class="w-48 h-8 bg-gray-100 p-2 border border-[#b2a5ff] rounded-md mr-2">

            <div id="searchFilters" class="text-gray-600" mr-4>
                <?php if (!isset($_GET['tab']) || $_GET['tab'] == "categories") getTopicsFilters(true);
                else if ($_GET['tab'] == "utilisateurs") getUsersFilters(true);
                else if ($_GET['tab'] == "posts") getPostsFilters(true);
                else if ($_GET['tab'] == "commentaires") getCommentsFilters(true);
                ?>
            </div>
            <input type="submit" value="Rechercher" id="search"
                   class="w-32 h-8 pb-1 pt-1 bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700 ml-8">
        </div>
    </form>
</div>
