<?php

namespace gui\views;

use gui\Layout;
use gui\View;

class ViewHome extends View {

    public function __construct(Layout $layout, string $documentTitle, $showNavbar = false, array $filters = array(), $isAdmin = false)
    {
        $fileName = "home.php";
        parent::__construct($layout, $documentTitle, $fileName, $showNavbar, $filters, $isAdmin);


    }




}