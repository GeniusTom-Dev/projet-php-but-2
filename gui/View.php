<?php

namespace gui;

class View{
    protected Layout $layout;
    protected string $documentTitle;
    protected string $content;

    public function __construct(Layout $layout, string $documentTitle, string $fileName = ""){
        $this->layout = $layout;
        $this->documentTitle = $documentTitle;
        if(empty($fileName) === false){
            ob_start();
            require_once __DIR__ . "/templates/" . $fileName;
            $this->content = ob_get_clean();
        }



    }

    public function render(): void{
        $this->layout->render($this->documentTitle, $this->content);
    }

    public function setContent(string $content): void{
        $this->content = $content;
    }

    public function addContentBefore(string $content): void{
        $this->content = $content . $this->content;
    }

    public function addContentAfter(string $content): void{
        $this->content .= $content;
    }
}