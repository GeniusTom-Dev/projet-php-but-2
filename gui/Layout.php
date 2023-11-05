<?php

namespace gui;
class Layout{

    public function __construct() {
    }

    public function render(string $documentTitle, string $content): void{
        $data = array("documentTitle" => $documentTitle);
        $header = $this->getHeaderPage();
        $footer = $this->getFooterPage();

        $page = $header . $content . $footer;

        $page = str_replace("{documentTitle}", $documentTitle, $page);
        extract($data);
        echo $page;
    }

    public function getHeaderPage(): string{
        ob_start();
        require_once __DIR__ . "/templates/header.html";
        return ob_get_clean();
    }

    public function getFooterPage(): string{
        ob_start();
        require_once __DIR__ . "/templates/footer.html";
        return ob_get_clean();

    }
}