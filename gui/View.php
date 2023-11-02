<?php

namespace gui;

class View{
    protected Layout $layout;
    protected string $documentTitle;
    protected string $content;

    public function __construct(Layout $layout, string $documentTitle, string $fileName){
        $this->layout = $layout;
        $this->documentTitle = $documentTitle;
        $content = file_get_contents("templates/" . $fileName);

    }

    public function render(): void{
        $this->layout->render($this->documentTitle, $this->content);
    }
}