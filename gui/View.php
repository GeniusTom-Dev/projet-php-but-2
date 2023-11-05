<?php

namespace gui;

class View
{
    protected Layout $layout;
    protected string $documentTitle;
    protected string $content;
    protected bool $showNavbar;
    protected array $filters;
    protected bool $isAdmin;

    public function __construct(Layout $layout, string $documentTitle, string $fileName = "", $showNavbar = false, array $filters = array(), $isAdmin = false)
    {
        $this->layout = $layout;
        $this->documentTitle = $documentTitle;
        if (empty($fileName) === false) {
            ob_start();
            require_once __DIR__ . "/templates/" . $fileName;
            $this->content = ob_get_clean();
        }
        $this->showNavbar = $showNavbar;
        $this->filters = $filters;
        $this->isAdmin = $isAdmin;
    }

    public function render(): void
    {
        $this->layout->render($this->documentTitle, $this->content, $this->showNavbar, $this->filters, $this->isAdmin);
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function addContentBefore(string $content): void
    {
        $this->content = $content . $this->content;
    }

    public function addContentAfter(string $content): void
    {
        $this->content .= $content;
    }
}