<?php

namespace gui\views;

use gui\Layout;
use gui\View;

class ViewProfile extends View {

    public function __construct(Layout $layout, string $documentTitle, $showNavbar = false)
    {
        $fileName = "profile.php";
        parent::__construct($layout, $documentTitle, $fileName, false);


    }




}