<script src="https://cdn.tailwindcss.com"></script>
<?php
function getTopicsFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <div class="flex flex-lign items-center mb-2">
            <label for="searchId" class="mr-2">Id&nbsp;=</label>
            <input type="number" id="searchId" name="searchId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff]"
                <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
        </div>
    <?php }
}

function getUsersFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <div class="flex flex-row items-center mb-2">
            <label for="searchId" class="mr-2">Id&nbsp;= </label>
            <input type="number" id="searchId" name="searchId" min="1" class=" w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
                <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
            <label for="searchIsAdmin" class="mr-2">Is&nbsp;Admin&nbsp;= </label>
            <input type="checkbox" id="searchIsAdmin" name="searchIsAdmin" class="mr-2"
                <?php if (isset($_GET["searchIsAdmin"]) && $_GET["searchIsAdmin"] === "on") echo "checked" ?>>

            <label for="searchIsActivated" class="mr-2">Is&nbsp;Activated&nbsp;= </label>
            <input type="checkbox" id="searchIsActivated" name="searchIsActivated" class="mr-2"
                <?php if (isset($_GET["searchIsActivated"]) && $_GET["searchIsActivated"] === "on") echo "checked" ?>>
        </div>
    <?php }
}

function getPostsFilters($isAdmin): void
{ ?>
    <div class="flex flex-row items-center mb-2">
    <?php if ($isAdmin) { ?>
        <label for="searchId" class="mr-2">Id&nbsp;= </label>
        <input type="number" id="searchId" name="searchId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
        <label for="searchUserId" class="mr-2">User&nbsp;Id&nbsp;= </label>
        <input type="number" id="searchUserId" name="searchUserId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchUserId'])) echo 'value=', $_GET['searchUserId']; ?>>

    <?php } else { ?>
        <label for="searchUser" class="mr-2">Auteur&nbsp;= </label>
        <input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchUser'])) echo 'value=', $_GET['searchUser']; ?>>
        <label for="searchTopic" class="mr-2">Entrée&nbsp;une&nbsp;catégorie&nbsp;= </label>
        <input type="text" id="searchTopic" name="searchTopic" placeholder="Rechercher une catégorie" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchTopic'])) echo 'value=', $_GET['searchTopic']; ?>>

    <?php } ?>
        <label for="searchDateMin" class="mr-2">De&nbsp;: </label>
        <input type="date" id="searchDateMin" name="searchDateMin" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchDateMin'])) echo 'value=', $_GET['searchDateMin']; ?>>
        <label for="searchDateMax" class="mr-2">A&nbsp;: </label>
        <input type="date" id="searchDateMax" name="searchDateMax" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchDateMax'])) echo 'value=', $_GET['searchDateMax']; ?>>
    </div>
<?php }

function getCommentsFilters($isAdmin): void
{?>
    <div class="flex flex-row items-center mb-2">
    <?php if ($isAdmin) { ?>
        <label for="searchPostId" class="mr-2">Post&nbsp;Id&nbsp;= </label>
        <input type="number" id="searchPostId" name="searchPostId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchPostId'])) echo 'value=', $_GET['searchPostId']; ?>>
        <label for="searchUserId" class="mr-2">User&nbsp;Id&nbsp;= </label>
        <input type="number" id="searchUserId" name="searchUserId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchUserId'])) echo 'value=', $_GET['searchUserId']; ?>>

    <?php } else { ?>
        <input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchUser'])) echo 'value=', $_GET['searchUser']; ?>>
    <?php } ?>
        <label for="searchDateMin" class="mr-2">De&nbsp;: </label>
        <input type="date" id="searchDateMin" name="searchDateMin" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchDateMin'])) echo 'value=', $_GET['searchDateMin']; ?>>
        <label for="searchDateMax" class="mr-2">A&nbsp;: </label>
        <input type="date" id="searchDateMax" name="searchDateMax" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
            <?php if (isset($_GET['searchDateMax'])) echo 'value=', $_GET['searchDateMax']; ?>>
    </div>
<?php }