<?php

namespace App\Exceptions;

class ThrottleException extends \Exception
{
    public function render()
    {
        return response($this->getMessage(), $this->getCode());
    }
}
