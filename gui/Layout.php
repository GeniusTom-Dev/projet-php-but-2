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
        return file_get_contents(__DIR__ . "/templates/header.html");
    }

    public function getFooterPage(): string{
        return file_get_contents(__DIR__ . "/templates/footer.html");

    }
}