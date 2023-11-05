<?php

namespace gui\views;

use controllers\searchResultController;
use gui\Layout;
use gui\View;

class ViewSearch extends View
{
    /**
     * Constructs a new instance of the class.
     *
     * @param Layout $layout The layout object.
     * @param string $documentTitle The document title.
     */
    public function __construct(Layout $layout, string $documentTitle, searchResultController $controller, $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, $limitRows, $pageNb, $sort)
    {
        $fileName = "search.php";
        parent::__construct($layout, $documentTitle, $fileName);
        $this->content . $this->setContent($this->content . str_replace("{results}", $controller->whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, $limitRows, $pageNb, $sort)));
    }
}