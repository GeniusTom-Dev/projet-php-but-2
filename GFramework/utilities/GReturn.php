<?php

namespace utilities;

/*
 * @author GeniusTom
 * @date = 02/07/2023 14h05
 * @title Class return
 * @desc Create return
 */

class GReturn{

    private $state;

    private $reason;

    private $content;

    private $levelDump;

    public function __construct($state, $reason = "", $content = []){
        $this->state = $state;
        $this->reason = $reason;
        $this->content = $content;
        $this->levelDump = 0;
    }

    /**
     * @return string
     */
    public function getState(): string{
        return $this->state;
    }

    /**
     * @return string
     */
    public function getReason(): string{
        return $this->reason;
    }

    /**
     * @return array|mixed
     */
    public function getContent(): mixed{
        return $this->content;
    }
}