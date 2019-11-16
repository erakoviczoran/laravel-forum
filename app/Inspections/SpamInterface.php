<?php

namespace App\Inspections;

interface SpamInterface
{
    function detect($body);
}
