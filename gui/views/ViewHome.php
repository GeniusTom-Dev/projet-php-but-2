<?php

namespace gui\views;

use gui\Layout;
use gui\View;

class ViewHome extends View {

    public function __construct(Layout $layout, string $documentTitle, array $filters = array(), $isAdmin = false)
    {
        $fileName = "home.php";
        parent::__construct($layout, $documentTitle, $fileName);
        $this->addContentAfter($this->getNavBar($filters, $isAdmin));


    }

    private function getNavBar($filters = array(), $isAdmin = false): string {
        ob_start();
        require_once __DIR__ . "/../templates/navbar.php";
        $content =  ob_get_clean();

        if(empty($filters) === false) {
            $content = str_replace("{filters}", $this->getSearchBarFilters($filters, $isAdmin), $content);
        }else{
            $content = str_replace("{filters}", "", $content);
        }
        return $content;
    }

    private function getSearchBarFilters(array $filters, $isAdmin): string {
        ?> <script>console.log(<?= json_encode($filters) ?>)</script><?php
        switch ($filters["selectOption"]) {
            case "Topics":
                return $this->getTopicsFilters($isAdmin);
            case "Users":
                return $this->getUsersFilters($isAdmin);
            case "Posts":
                return $this->getPostsFilters($isAdmin);
            case "Comments":
                return $this->getCommentsFilters($isAdmin);
            default:
                return "";
        }

    }

    private function getTopicsFilters($isAdmin): string{
        if ($isAdmin) {
            return '
            <div class="flex flex-row items-center mb-2">
                <label for="searchId" class="mr-2">Id&nbsp;=</label>
                <input type="number" id="searchId" name="searchId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff]">
            </div>';
        }
        return "";

    }

    private function getUsersFilters($isAdmin): string
    {
        if ($isAdmin) {
            return '
            <div class="flex flex-row items-center mb-2">
                <label for="searchId" class="mr-2">Id&nbsp;= </label>
                <input type="number" id="searchId" name="searchId" min="1" class=" w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">
                <label for="searchIsAdmin" class="mr-2">Is&nbsp;Admin&nbsp;= </label>
                <input type="checkbox" id="searchIsAdmin" name="searchIsAdmin" class="mr-2">

                <label for="searchIsActivated" class="mr-2">Is&nbsp;Activated&nbsp;= </label>
                <input type="checkbox" id="searchIsActivated" name="searchIsActivated" class="mr-2">
            </div>';
         }
        return "";
    }

    private function getPostsFilters($isAdmin): string
    {
        $content = '<div class="flex flex-row items-center mb-2">';
        if($isAdmin) {
            $content .= '<label for="searchId" class="mr-2">Id&nbsp;= </label>
                <input type="number" id="searchId" name="searchId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">
                <label for="searchUserId" class="mr-2">User&nbsp;Id&nbsp;= </label>
                <input type="number" id="searchUserId" name="searchUserId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">';
        }else{
            $content .= '<input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">
                <input type="text" name="searchInputTopic" id="searchInputTopic" placeholder="Cliquez pour rechercher..." autocomplete="off" class="searchInputTopic h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">';
        }
        $content .= '
            <label for="searchDateMin" class="mr-2">De&nbsp;: </label>
            <input type="date" id="searchDateMin" name="searchDateMin" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2 pl-4">
            <label for="searchDateMax" class="mr-2">A&nbsp;: </label>
            <input type="date" id="searchDateMax" name="searchDateMax" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2 pl-4">
        </div>';

    return $content;
    }

    private function getCommentsFilters($isAdmin): string{
        $content = '<div class="flex flex-row items-center mb-2">';
         if ($isAdmin) {
             $content .= '
                <label for="searchPostId" class="mr-2">Post&nbsp;Id&nbsp;= </label>
                <input type="number" id="searchPostId" name="searchPostId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">
                <label for="searchUserId" class="mr-2">User&nbsp;Id&nbsp;= </label>
                <input type="number" id="searchUserId" name="searchUserId" min="1" class="w-20 h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">';

         } else {
                $content = '<input type="text" id="searchUser" name="searchUser" placeholder="Rechercher un utilisateur" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2">';
         }
        $content .= '
            <label for="searchDateMin" class="mr-2">De&nbsp;: </label>
            <input type="date" id="searchDateMin" name="searchDateMin" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2 pl-4">
            <label for="searchDateMax" class="mr-2">A&nbsp;: </label>
            <input type="date" id="searchDateMax" name="searchDateMax" class="h-8 rounded-md bg-gray-100 border border-[#b2a5ff] mr-2 pl-4">
        </div>';
         return $content;
    }


}