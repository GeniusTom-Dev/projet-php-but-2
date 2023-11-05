<?php

namespace gui\views;

use gui\Layout;
use gui\View;

class ViewHome extends View {

    public function __construct(Layout $layout, string $documentTitle, string $fileName)
    {
        parent::__construct($layout, $documentTitle, $fileName);


    }


}