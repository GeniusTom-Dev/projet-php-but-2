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
            $this->content = file_get_contents(__DIR__ . "/templates/" . $fileName);
        }



    }

    public function render(): void{
        $this->layout->render($this->documentTitle, $this->content);
    }

    public function setContent(string $content): void{
        $this->content = $content;
    }
}