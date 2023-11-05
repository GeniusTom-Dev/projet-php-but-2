<?php

namespace gui\views;

use gui\Layout;
use gui\View;

class ViewRegister extends View {

    /**
     * Constructs a new instance of the class.
     *
     * @param Layout $layout The layout object.
     * @param string $documentTitle The document title.
     */
    public function __construct(Layout $layout, string $documentTitle){
        $fileName = "register.php";
        parent::__construct($layout, $documentTitle, $fileName);

    }


}