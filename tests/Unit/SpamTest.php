<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Exception;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /** @test */
    public function itCheckForInvalidKeywords()
    {
        $spam = new Spam();

        $body = 'innocent reply here.';

        $this->assertFalse($spam->detect($body));

        $this->expectException(Exception::class);

        $spam->detect('yahoo customer support');
    }

    /** @test **/
    public function itChecksForAnyKeyBeingHeldDown()
    {
        $spam = new Spam();

        $this->expectException(Exception::class);

        $spam->detect('Hello world aaaaaaaaa');
    }
}
