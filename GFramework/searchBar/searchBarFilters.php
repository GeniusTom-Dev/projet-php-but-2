<?php
function getTopicsFilters($isAdmin): void
{
    if ($isAdmin) {
        echo '<label for="searchId">Id = </label>';
        echo '<input type="number" id="searchId" name="searchId" min="1" style="width: 50px">';
    }
}

function getUsersFilters($isAdmin): void
{
    if ($isAdmin) {
        echo '<label for="searchId">Id = </label>';
        echo '<input type="number" id="searchId" name="searchId" min="1" style="width: 50px">';
        echo '<label for="searchIsAdmin">Is Admin = </label>';
        echo '<input type="checkbox" id="searchIsAdmin" name="searchIsAdmin" <?php if ($_GET["searchIsAdmin"] === "on") echo "checked" ?>>';
        echo '<label for="searchIsActivated">Is Activated = </label>';
        echo '<input type="checkbox" id="searchIsActivated" name="searchIsActivated" <?php if ($_GET["searchIsActivated"] === "on") echo "checked" ?>>';
    }
}

function getPostsFilters($isAdmin): void
{
    if ($isAdmin) {
        echo '<label for="searchId">Id = </label>';
        echo '<input type="number" id="searchId" name="searchId" min="1" style="width: 50px">';
        echo '<label for="searchUserId">User Id = </label>';
        echo '<input type="number" id="searchUserId" name="searchUserId" min="1" style="width: 50px">';
    } else {
        echo '<input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur">';
    }
    echo '<label for="searchDateMin">De : </label>';
    echo '<input type="date" id="searchDateMin" name="searchDateMin">';
    echo '<label for="searchDateMax">A : </label>';
    echo '<input type="date" id="searchDateMax" name="searchDateMax">';
}

function getCommentsFilters($isAdmin): void
{
    if ($isAdmin) {
        echo '<label for="searchId">Post Id = </label>';
        echo '<input type="number" id="searchPostId" name="searchPostId" min="1" style="width: 50px">';
        echo '<label for="searchUserId">User Id = </label>';
        echo '<input type="number" id="searchUserId" name="searchUserId" min="1" style="width: 50px">';
    } else {
        echo '<input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur">';
    }
    echo '<label for="searchDateMin">De : </label>';
    echo '<input type="date" id="searchDateMin" name="searchDateMin">';
    echo '<label for="searchDateMax">A : </label>';
    echo '<input type="date" id="searchDateMax" name="searchDateMax">';
}

