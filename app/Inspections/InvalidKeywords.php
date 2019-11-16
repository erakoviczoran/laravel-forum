<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords implements SpamInterface
{
    private $keywords = [
        'yahoo customer support',
    ];

    public function detect($body)
    {

        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Your reply contains spam.');
            }
        }
    }
}
