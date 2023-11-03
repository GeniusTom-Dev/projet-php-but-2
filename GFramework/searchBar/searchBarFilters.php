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
        <div class="flex flex-lign items-center mb-2">
            <div class="flex flex-lign items-center mb-2">
                <label for="searchId" class="mr-2">Id&nbsp;= </label>
                <input type="number" id="searchId" name="searchId" min="1" class=" w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2"
                    <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
            </div>
            <div class="flex flex-lign items-center mb-2">
                <label for="searchIsAdmin" class="mr-2">Is&nbsp;Admin&nbsp;= </label>
                <input type="checkbox" id="searchIsAdmin" name="searchIsAdmin" class="mr-2"
                    <?php if (isset($_GET["searchIsAdmin"]) && $_GET["searchIsAdmin"] === "on") echo "checked" ?>>
            </div>
            <div class="flex flex-lign items-center mb-2">
                <label for="searchIsActivated" class="mr-2">Is&nbsp;Activated&nbsp;= </label>
                <input type="checkbox" id="searchIsActivated" name="searchIsActivated" class="mr-2"
                    <?php if (isset($_GET["searchIsActivated"]) && $_GET["searchIsActivated"] === "on") echo "checked" ?>>
            </div>
        </div>
    <?php }
}

function getPostsFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <div class="flex flex-lign items-center mb-2">
            <div class="flex flex-lign items-center mb-2">
                <label for="searchId" class="mr-2">Id&nbsp;= </label>
                <input type="number" id="searchId" name="searchId" min="1" class="mr-2"
                    <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
            </div>
            <div class="flex flex-lign items-center mb-2">
                <label for="searchUserId" class="mr-2">User&nbsp;Id&nbsp;= </label>
                <input type="number" id="searchUserId" name="searchUserId" min="1" class="mr-2"
                    <?php if (isset($_GET['searchUserId'])) echo 'value=', $_GET['searchUserId']; ?>>
            </div>
        </div>
    <?php } else { ?>
        <div class="flex flex-lign items-center mb-2">
            <div class="flex flex-lign items-center mb-2">
                <label for="searchUser" class="mr-2">Auteur&nbsp;= </label>
                <input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" class="mr-2"
                    <?php if (isset($_GET['searchUser'])) echo 'value=', $_GET['searchUser']; ?>>
            </div>
            <div class="flex flex-lign items-center mb-2">
                <label for="searchTopic" class="mr-2">Entrée&nbsp;une&nbsp;catégorie&nbsp;= </label>
                <input type="text" id="searchTopic" name="searchTopic" placeholder="Rechercher une catégorie" class="mr-2"
                    <?php if (isset($_GET['searchTopic'])) echo 'value=', $_GET['searchTopic']; ?>>
            </div>
        </div>
    <?php } ?>
    <div class="flex flex-lign items-center mb-2">
        <div class="flex flex-lign items-center mb-2">
            <label for="searchDateMin">De&nbsp;: </label>
            <input type="date" id="searchDateMin" name="searchDateMin" <?php if (isset($_GET['searchDateMin'])) echo 'value=', $_GET['searchDateMin']; ?>>
        </div>
        <div class="flex flex-lign items-center mb-2">
            <label for="searchDateMax">A&nbsp;: </label>
            <input type="date" id="searchDateMax" name="searchDateMax" <?php if (isset($_GET['searchDateMax'])) echo 'value=', $_GET['searchDateMax']; ?>>
        </div>
    </div>
<?php }

function getCommentsFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <div class="flex flex-lign items-center mb-2">
            <div class="flex flex-lign items-center mb-2">
                <label for="searchPostId" class="mr-2">Post&nbsp;Id&nbsp;= </label>
                <input type="number" id="searchPostId" name="searchPostId" min="1" class="mr-2"
                    <?php if (isset($_GET['searchPostId'])) echo 'value=', $_GET['searchPostId']; ?>>
            </div>
            <div class="flex flex-lign items-center mb-2">
                <label for="searchUserId" class="mr-2">User&nbsp;Id&nbsp;= </label>
                <input type="number" id="searchUserId" name="searchUserId" min="1" class="mr-2"
                    <?php if (isset($_GET['searchUserId'])) echo 'value=', $_GET['searchUserId']; ?>>
            </div>
        </div>
    <?php } else { ?>
        <input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" class="mr-2"
            <?php if (isset($_GET['searchUser'])) echo 'value=', $_GET['searchUser']; ?>>
    <?php } ?>
    <div class="flex flex-lign items-center mb-2">
        <div class="flex flex-lign items-center mb-2">
            <label for="searchDateMin" class="mr-2">De&nbsp;: </label>
            <input type="date" id="searchDateMin" name="searchDateMin" class="mr-2"
                <?php if (isset($_GET['searchDateMin'])) echo 'value=', $_GET['searchDateMin']; ?>>
        </div>
        <div class="flex flex-lign items-center mb-2">
            <label for="searchDateMax" class="mr-2">A&nbsp;: </label>
            <input type="date" id="searchDateMax" name="searchDateMax" class="mr-2"
                <?php if (isset($_GET['searchDateMax'])) echo 'value=', $_GET['searchDateMax']; ?>>
        </div>
    </div>
<?php }