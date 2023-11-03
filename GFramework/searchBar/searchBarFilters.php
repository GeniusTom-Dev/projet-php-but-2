<?php
function getTopicsFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <label for="searchId">Id = </label>
        <input type="number" id="searchId" name="searchId" min="1" style="width: 50px" <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
    <?php }
}

function getUsersFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <label for="searchId">Id = </label>
        <input type="number" id="searchId" name="searchId" min="1" style="width: 50px" <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
        <label for="searchIsAdmin">Is Admin = </label>
        <input type="checkbox" id="searchIsAdmin" name="searchIsAdmin" <?php if (isset($_GET["searchIsAdmin"]) && $_GET["searchIsAdmin"] === "on") echo "checked" ?>>
        <label for="searchIsActivated">Is Activated = </label>
        <input type="checkbox" id="searchIsActivated" name="searchIsActivated" <?php if (isset($_GET["searchIsActivated"]) && $_GET["searchIsActivated"] === "on") echo "checked" ?>>
    <?php }
}

function getPostsFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <label for="searchId">Id = </label>
        <input type="number" id="searchId" name="searchId" min="1" style="width: 50px" <?php if (isset($_GET['searchId'])) echo 'value=', $_GET['searchId']; ?>>
        <label for="searchUserId">User Id = </label>
        <input type="number" id="searchUserId" name="searchUserId" min="1" style="width: 50px" <?php if (isset($_GET['searchUserId'])) echo 'value=', $_GET['searchUserId']; ?>>
    <?php } else { ?>
        <label for="searchUser">Auteur = </label>
        <input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" <?php if (isset($_GET['searchUser'])) echo 'value=', $_GET['searchUser']; ?>>
        <?php include "onlyTopicSearchBar.php"?>
<!--        <input type="text" id="searchTopic" name="searchTopic" placeholder="Rechercher une catégorie" <?php /*if (isset($_GET['searchTopic'])) echo 'value=', $_GET['searchTopic']; */?>>
-->    <?php } ?>
    <label for="searchDateMin">De : </label>
    <input type="date" id="searchDateMin" name="searchDateMin" <?php if (isset($_GET['searchDateMin'])) echo 'value=', $_GET['searchDateMin']; ?>>
    <label for="searchDateMax">A : </label>
    <input type="date" id="searchDateMax" name="searchDateMax" <?php if (isset($_GET['searchDateMax'])) echo 'value=', $_GET['searchDateMax']; ?>>
<?php }

function getCommentsFilters($isAdmin): void
{
    if ($isAdmin) { ?>
        <label for="searchPostId">Post Id = </label>
        <input type="number" id="searchPostId" name="searchPostId" min="1" style="width: 50px" <?php if (isset($_GET['searchPostId'])) echo 'value=', $_GET['searchPostId']; ?>>
        <label for="searchUserId">User Id = </label>
        <input type="number" id="searchUserId" name="searchUserId" min="1" style="width: 50px" <?php if (isset($_GET['searchUserId'])) echo 'value=', $_GET['searchUserId']; ?>>
    <?php } else { ?>
        <input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" <?php if (isset($_GET['searchUser'])) echo 'value=', $_GET['searchUser']; ?>>
    <?php } ?>
    <label for="searchDateMin">De : </label>
    <input type="date" id="searchDateMin" name="searchDateMin" <?php if (isset($_GET['searchDateMin'])) echo 'value=', $_GET['searchDateMin']; ?>>
    <label for="searchDateMax">A : </label>
    <input type="date" id="searchDateMax" name="searchDateMax" <?php if (isset($_GET['searchDateMax'])) echo 'value=', $_GET['searchDateMax']; ?>>
<?php }

