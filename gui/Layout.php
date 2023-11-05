<?php

namespace gui;

use controllers\NavbarController;

class Layout
{

    public function __construct()
    {
    }

    public function render(string $documentTitle, string $content, bool $showNavbar = false, array $filters = array(), $isAdmin = false): void
    {
        $data = array("documentTitle" => $documentTitle);
        $header = $this->getHeaderPage();
        if ($showNavbar === true) {
            $header .= $this->getNavBar($filters, $isAdmin) . $header;
        }

        $footer = $this->getFooterPage();

        $page = $header . $content . $footer;

        $page = str_replace("{documentTitle}", $documentTitle, $page);

        extract($data);
        echo $page;
    }

    public function getHeaderPage(): string
    {
        ob_start();
        require_once __DIR__ . "/templates/header.html";
        return ob_get_clean();
    }

    public function getFooterPage(): string
    {
        ob_start();
        require_once __DIR__ . "/templates/footer.html";
        return ob_get_clean();

    }

    private function getNavBar($filters = array(), $isAdmin = false): string
    {
        $navbarController = new NavbarController();
        ob_start();
        require_once __DIR__ . "/templates/navbar.php";
        $content = ob_get_clean();

        if (empty($filters) === false) {
            $content = str_replace("{filters}", $navbarController->getSearchBarFilters($filters, $isAdmin), $content);
        } else {
            $content = str_replace("{filters}", "", $content);
        }
        return $content;
    }
}