<?php

namespace utilities;

class CannotDoException extends \Exception
{
    private string $default_msg = 'An action cannot be executed.';
    private string $target;
    private string $action;
    private string $explanation;


    public function __construct(string $target = '', string $action ='', string $explanation = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($this->default_msg, $code, $previous);
        $this->target = $target;
        $this->action = $action;
        $this->explanation = $explanation;
    }

    public function getReport(): string{
        $report = $this->default_msg . '\n';
        $report .= 'Target: ' . $this->target . '\n';
        $report .= 'Action concerned: ' . $this->action . '\n';
        $report .= 'Cause: ' . $this->explanation;
        return $report;
    }

}